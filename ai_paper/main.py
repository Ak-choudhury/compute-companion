from flask import Flask, render_template, request, jsonify
import openai
from openai import OpenAI
from dotenv import load_dotenv
import os
import hashlib
import re

# Load environment variables from .env file
load_dotenv()

# Retrieve the API key from environment variables
openai.api_key =  os.getenv("OPENAI_API_KEY")

app = Flask(__name__, template_folder='.', static_folder='.')

def generate_questions(topic):
    prompt = (
        f"Generate 20 multiple-choice exam questions on the topics from ocr computer science  '{topic}' appropriate for a level student which test there ao1, ao2 and ao3 exam skills. "
        f"Each question should have four answer choices labeled A, B, C, and D, with one correct answer clearly indicated. "
        f"make sure that the questions generated test ocrs exam objectives AO1,AO2,AO3 make sure there is a mix of each but more ao3 and reasoning qs"
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

    client = OpenAI()

    response = client.chat.completions.create(
        model="gpt-4o-mini",
        messages=[{"role": "user", "content": prompt}],
        max_tokens=1500
)

    return response.choices[0].message['content'].strip()

def hash_match(match):
    match_text = match.group(0)
    hashed_value = hashlib.sha256(match_text.encode()).hexdigest()
    return hashed_value

@app.route('/ai_paper/')
def home():
    return render_template('ai_paper/index.html')

@app.route('/ai_paper/quiz', methods=['POST'])
def quiz():
    topic = request.form.get('topic')
    level = request.form.get('level')
    
    questions = generate_questions(topic)
    print(questions)

    # Replace the correct answer with its hashed value
    questions = re.sub(r'123: .', hash_match, questions)
 
    return render_template('quiz.html', questions=questions.replace("\n", ""))

@app.route('/ai_paper/result', methods=['POST'])
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

    total_questions = total_questions / 2
    score_percentage = (correct_count / total_questions) * 100 if total_questions > 0 else 0

    return render_template(
        "result.html",
        results=results,
        correct_count=correct_count,
        total_questions=total_questions,
        score_percentage=score_percentage,
    )

if __name__ == '__main__':
    app.run(debug=True, host='0.0.0.0', port=5000)  # Listen on all interfaces
