import openai
from flask import Flask, render_template, request, jsonify
import os
import json
from dotenv import load_dotenv
import jinja2

# Load environment variables from .env file
load_dotenv()
openai.api_key = os.getenv("OPENAI_API_KEY")

app = Flask(__name__, template_folder='templates', static_folder='static')
app.jinja_env.globals.update(enumerate=enumerate)


def generate_questions(topic, num_questions):
    mcq_count = int(num_questions * 0.4)  # 40% MCQs
    typed_count = num_questions - mcq_count  # 60% Typed Questions

    prompt = f"""
    Generate {mcq_count} MCQs and {typed_count} typed questions on the topic "{topic} make sure you include AO1,AO2,AO3 questions and some synoptic questions". 

    Format:
    [
        {{
            "type": "MCQ",
            "question_text": "Example MCQ question?",
            "options": ["Option A", "Option B", "Option C", "Option D"],
            "correct_answer": "Option A",
            "marks": 1
        }},
        {{
            "type": "Typed",
            "question_text": "Explain the concept of X.",
            "correct_answer": "Detailed explanation here.",
            "marks": 2
        }}
    ]
    """

    response = openai.ChatCompletion.create(
        model="gpt-4o-mini",
        messages=[{"role": "system", "content": "You are an AI quiz generator."},
                  {"role": "user", "content": prompt}],
        max_tokens=1000,
        temperature=0.6
    )

    print(f"Raw Response: {response}")  # Debugging the raw response

    try:
        questions = json.loads(response['choices'][0]['message']['content'].strip())
        return questions
    except json.JSONDecodeError as e:
        print(f"JSON Decode Error: {e}")
        return []

def evaluate_answer_with_ai(question, user_response):
    max_marks = question['marks']
    correct_answer = question['correct_answer']

    prompt = f"""
You are a strict but fair A-Level examiner.

Question: {question['question_text']}
Correct Answer (Mark Scheme): {correct_answer}
Student Answer: {user_response}
Maximum Marks: {max_marks}

Evaluate the student's answer. Award a mark from 0 to {max_marks}. Also explain the reasoning behind the awarded marks.

Respond in this JSON format:
{{
    "marks_awarded": X,
    "feedback": "Explanation of why the mark was awarded",
    "corrections": "What the student could have improved"
}}
"""

    response = openai.ChatCompletion.create(
        model="gpt-4o-mini",
        messages=[
            {"role": "system", "content": "You are an AI exam marker."},
            {"role": "user", "content": prompt}
        ],
        temperature=0.1,
        max_tokens=300
    )

    try:
        ai_feedback = json.loads(response['choices'][0]['message']['content'])
        return ai_feedback
    except json.JSONDecodeError as e:
        return {
            "marks_awarded": 0,
            "feedback": "There was an error processing your answer.",
            "corrections": "Please try again."
        }

@app.route('/new_gs/', methods=['GET', 'POST'])
def index():
    if request.method == 'POST':
        topic = request.form.get('topic')
        num_questions = request.form.get('num_questions')
        print(f"[DEBUG] Topic: {topic}, Num Questions: {num_questions}")  # ✅ Add this
        questions = generate_questions(topic, int(num_questions))
        return render_template('quiz.html', questions=questions, topic=topic)
    return render_template('index.html')

@app.route('/new_gs/templates/quiz')
def quiz():
    # Sample data for dynamic questions (replace with actual dynamic data)
    questions = [
        {'question_text': 'What is 2 + 2?', 'options': ['3', '4', '5'], 'correct_answer': '4', 'type': 'MCQ'},
        {'question_text': 'What is the capital of France?', 'options': ['Paris', 'London', 'Berlin'], 'correct_answer': 'Paris', 'type': 'MCQ'},
        {'question_text': 'Explain the theory of relativity.', 'type': 'Text'},
        {'question_text': 'Describe Newton\'s second law.', 'type': 'Text'},
        {'question_text': 'What is the square root of 16?', 'options': ['2', '3', '4'], 'correct_answer': '4', 'type': 'MCQ'}
    ]
    return render_template('quiz.html', questions=questions, topic="Math & Physics")

@app.route('/submit_answers', methods=['POST'])
def submit_answers():
    try:
        # Retrieve the questions and user answers
        questions = json.loads(request.form['questions'])
        user_answers = {
            f"answer_{i}": request.form.get(f"answer_{i}", "")
            for i in range(len(questions))
        }

        feedback = []
        for i, question in enumerate(questions):
            user_answer = user_answers.get(f"answer_{i}", "")
            correct_answer = question.get("correct_answer", "")
            max_marks = question.get("marks", 1)

            if question['type'] == "MCQ":
                if user_answer.strip().lower() == correct_answer.strip().lower():
                    marks_awarded = max_marks
                    feedback.append({
                        "marks_awarded": marks_awarded,
                        "feedback": "✅ Correct!",
                        "corrections": "N/A"
                    })
                else:
                    feedback.append({
                        "marks_awarded": 0,
                        "feedback": "❌ Incorrect!",
                        "corrections": f"Correct answer: {correct_answer}"
                    })
            else:
                # Use AI to evaluate typed answer with partial credit
                result = evaluate_answer_with_ai(question, user_answer)
                feedback.append({
                    "marks_awarded": result.get("marks_awarded", 0),
                    "feedback": result.get("feedback", "No feedback"),
                    "corrections": result.get("corrections", "N/A")
                })

        return render_template("feedback.html", questions=questions, feedback=feedback, user_answers=user_answers)

    except Exception as e:
        return f"Error processing answers: {str(e)}", 500

def evaluate_answers(user_answers, questions):
    feedback = []
    for idx, question in enumerate(questions):
        question_key = f'question_{idx + 1}'
        user_answer = user_answers.get(question_key)

        if question['type'] == 'MCQ':
            if user_answer == question.get('correct_answer'):
                feedback.append(f"Q{idx + 1}: Correct!")
            else:
                feedback.append(f"Q{idx + 1}: Incorrect. The correct answer is {question.get('correct_answer')}.")
        else:
            # For text-based questions, you can use simple checks or AI to evaluate the response
            if user_answer and len(user_answer.strip()) > 0:
                feedback.append(f"Q{idx + 1}: Your answer was received.")
            else:
                feedback.append(f"Q{idx + 1}: Please provide an answer.")

    return feedback



@app.route("/new_gs/templates/feedback")
def feedback():
    return render_template("feedback.html")

if __name__ == "__main__":
    app.run(debug=True, host='0.0.0.0', port=5001)
