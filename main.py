from flask import Flask, render_template, request, jsonify
import openai
from dotenv import load_dotenv
import os
import hashlib

# Load environment variables from .env file
load_dotenv()

# Retrieve the API key from environment variables
openai.api_key = os.getenv("OPENAI_API_KEY")

app = Flask(__name__, template_folder='.', static_folder='.')

def generate_questions(topic, level, num_questions):
    prompt = (
        f"Generate {num_questions} multiple-choice questions on the topic '{topic}' precisly folow the structure below and do not apply any spelling corrections keep the <br> at the end of each line:"
        f"appropriate for a level student. Each question should include four "
        f"answer choices labeled A, B, C, and D, with one correct answer. Do not include "
        f"introductions or summaries or any other words like or between the question s and each awnser and clearly seperate ou teach option. Format each question as:<br>"
        f"Question: <question text><br>"
        f"A. <option 1><br>"
        f"B. <option 2><br>"
        f"C. <option 3><br>"
        f"D. <option 4> <br>"
        f"23423423423: <correct letter>"
    )
    
    response = openai.ChatCompletion.create(
        model="gpt-3.5-turbo",  # Use "gpt-4" if available
        messages=[{"role": "user", "content": prompt}],
        max_tokens=500  # Adjust if needed for more questions or longer questions
    )

    # Split the response into lines
    print(response)

    return response.choices[0].message['content'].strip()

@app.route('/')
def home():
    return render_template('revision.php')

@app.route('/quiz', methods=['POST'])
def quiz():
    topic = request.form.get('topic')
    level = request.form.get('level')
    num_questions = int(request.form.get('num_questions', 5))
    questions = generate_questions(topic, level, num_questions)
    print(questions)
    lines = questions.split('\n')

    # Identify the last line and extract the correct answer
    if lines[-1].startswith("23423423423: "):
        correct_answer = lines[-1]
        
        # SHA-256 encrypt the correct answer
        sha256_hash = hashlib.sha256(correct_answer.encode()).hexdigest()
        
        # Replace the last line with the encrypted correct answer
        lines[-1] = sha256_hash

    # Join the modified lines back into a multi-line string
    questions = '\n'.join(lines)

# Output the updated response
    print(questions)
    
    # Render the template with the modified questions and hash
    return render_template('revision_qs.php', questions=questions)

@app.route('/result', methods=['POST'])
def result():
    # Collect and display quiz answers here (not implemented for this example)
    return render_template('revision_results.php')

if __name__ == '__main__':
    app.run(debug=True)