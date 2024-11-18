#from dotenv import load_dotenv
#load_dotenv()
#import requests
#from random import randint
#import os 
#from transformers import AutoModelForCausalLM, AutoTokenizer
#import torch

#print(float('0.'+str(randint(0,9))))

#list = ['computer science', 'A level', 'networks', 10, 'ocr']
#model_name = "nvidia/Llama-3.1-Nemotron-70B-Instruct-HF"
#model = AutoModelForCausalLM.from_pretrained(model_name)
#tokenizer = AutoTokenizer.from_pretrained(model_name)
#def generate_text(prompt):
    #inputs = tokenizer(prompt, return_tensors="pt")
    #outputs = model.generate(inputs["input_ids"], max_length=150, do_sample=True, top_p=0.9, top_k=50)
   # return tokenizer.decode(outputs[0], skip_special_tokens=True)

print(generate_text(f'give me {list[3]} {list[0]} {list[1]} {list[4]} questions on {list[2]} without an introduction, summary, conclusion'))

from flask import Flask, request, jsonify
from transformers import pipeline

# Initialize the Flask app
app = Flask(__name__)

# Load the question generation model once at startup
question_generator = pipeline("text2text-generation", model="valhalla/t5-small-qg-prepend")

# Define an endpoint to generate questions
@app.route('/generate-questions', methods=['POST'])
def generate_questions():
    data = request.get_json()
    text = data.get("text", "")
    if not text:
        return jsonify({"error": "No text provided"}), 400
    
    # Generate questions
    questions = question_generator(text)
    
    # Extract and format the generated questions
    formatted_questions = [q["generated_text"] for q in questions]
    
    return jsonify({"questions": formatted_questions})

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000)