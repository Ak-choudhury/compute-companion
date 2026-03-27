from flask import Flask, render_template, request
from openai import OpenAI
from dotenv import load_dotenv
import hashlib
import re

load_dotenv()

app = Flask(__name__, template_folder='.', static_folder='.')
client = OpenAI()

def generate_questions(topic, level, num_questions):
    prompt = (
        f"Generate {num_questions} multiple-choice questions on the topic '{topic}' appropriate for OCR A-Level Computer Science students and test AO1, AO2 and AO3 exam skills. "
        f"Each question should have four answer choices labeled A, B, C, and D, with one correct answer clearly indicated. "
        f"Keep the questions specific to OCR A-Level Computer Science and generate questions based only on what is in the specification and nothing else. "
        f"Also use language and notations specified in the OCR specification. "
        f"Make sure there is a mix of AO1, AO2 and AO3 questions, with more AO3 and reasoning questions. "
        f"Follow this structure strictly and use <br> to separate each line of output:<br>"
        f"<br>Question 1: <question text><br>"
        f"A. <option 1><br>"
        f"B. <option 2><br>"
        f"C. <option 3><br>"
        f"D. <option 4><br>"
        f"123: <correct letter><br>"
        f"<br>Question 2: <question text><br>"
        f"A. <option 1><br>"
        f"B. <option 2><br>"
        f"C. <option 3><br>"
        f"D. <option 4><br>"
        f"123: <correct letter><br>"
    )

    response = client.chat.completions.create(
        model="gpt-4o-mini",
        messages=[{"role": "user", "content": prompt}],
        max_tokens=800
    )

    return response.choices[0].message.content.strip()

def hash_match(match):
    match_text = match.group(0)
    hashed_value = hashlib.sha256(match_text.encode()).hexdigest()
    return hashed_value

@app.route('/')
def home():
    return render_template('index.html')

@app.route('/question_generation/quiz', methods=['POST'])
def quiz():
    topic = request.form.get('topic')
    level = request.form.get('level')
    num_questions_raw = request.form.get('num_questions', '5')

    if not topic:
        return "Missing topic", 400

    try:
        num_questions = int(num_questions_raw)
    except ValueError:
        return "Invalid number of questions", 400

    questions = generate_questions(topic, level, num_questions)
    questions = re.sub(r'123: .', hash_match, questions)

    return render_template('quiz.html', questions=questions.replace("\n", ""))

@app.route('/question_generation/result', methods=['POST'])
def result():
    submitted_answers = request.form.to_dict()
    results = []
    correct_count = 0
    total_questions = 0

    for key, value in submitted_answers.items():
        if key.startswith("answer_"):
            question_number = key.split("_")[1]
            decrypted_user_answer = "123: " + value
            user_answer_hash = hashlib.sha256(decrypted_user_answer.encode()).hexdigest()
            hash_key = f"answer_hash_{question_number}"
            correct_answer_hash = submitted_answers.get(hash_key)

            if correct_answer_hash:
                is_correct = (user_answer_hash == correct_answer_hash)
                if is_correct:
                    correct_count += 1

                results.append({
                    "question_number": question_number,
                    "user_answer": value,
                    "is_correct": is_correct,
                })

                total_questions += 1

    score_percentage = (correct_count / total_questions) * 100 if total_questions > 0 else 0

    return render_template(
        "result.html",
        results=results,
        correct_count=correct_count,
        total_questions=total_questions,
        score_percentage=score_percentage,
    )

if __name__ == '__main__':
    app.run(debug=False, host='0.0.0.0', port=5000)