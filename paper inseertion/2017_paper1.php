<?php
// Database connection
require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
include('connection.php');
if(mysqli_connect_errno()) { // built in function 
    echo "sql connect err";
  } else {}

// Insert Paper Information
$subject = "Computer Science";
$year = 2017;
$total_marks = 128;

$insert_paper_sql = "INSERT INTO papers (subject, year, total_marks) VALUES ('$subject', $year, $total_marks)";
if ($conn->query($insert_paper_sql) === TRUE) {
    $paper_id = $conn->insert_id;
    echo "New paper added successfully. Paper ID is: " . $paper_id . "<br>";
} else {
    echo "Error: " . $insert_paper_sql . "<br>" . $conn->error;
}

// Example questions with multiple types and parts
$questions = [
    [
        "text" => "An architect firm specialises in designing skyscrapers. ",
        "type" => "OE",
        "marks" => 14,
        "parts" => [
            [
                "label" => "ai",
                "text" => "The firm uses high end computers with high performance CPUs, GPUs and large amounts of RAM. Give one use the firm might have for GPUs",
                "type" => "OE",
                "marks" => 1,
                "mark_schemes" => [
                    "To render models of proposed buildings",
                    "Run CAD software",
                    "Run modelling calculations."
                    
                ]
            ],
            [
                "label" => "aii",
                "text" => "Describe what is meant by the term ‘RAM’.",
                "type" => "OE",
                "marks" => 2,
                "mark_schemes" => [
                    "Random Access Memory",
                    "A form of primary memory",
                    "Used to hold data and/or programs in use.",
                    "Volatile/Loses its contents when power is lost"
                    
                ]
            ],
            [
                "label" => "aiii",
                "text" => "State one characteristic a high performance CPU might have",
                "type" => "MC",
                "marks" => 1,
                "options" => [
                    ["text" => "Block all data", "is_correct" => 0],
                    ["text" => "Fast Clock Speed", "is_correct" => 1],
                    ["text" => "Multiple Cores", "is_correct" => 1],
                    ["text" => "Perform encryption", "is_correct" => 0],
                    ["text" => "Ability to use pipelining ", "is_correct" => 1],
                    ["text" => "Perform encryption", "is_correct" => 0],
                    ["text" => "Large Cache ", "is_correct" => 1],
                    ["text" => "Perform encryption", "is_correct" => 0],
                ]
                
            ],
            [
                "label" => "bi",
                "text" => "Each computer has a multi-tasking operating system installed. State the name of and describe two methods that the operating system can use to divide the contents of RAM",
                "type" => "OE",
                "marks" => 4,
                "mark_schemes" => [
                    "Paging",
                    "Memory is divided into fixed/physical units",
                    "Segmentation",
                    "Memory is divided logically/variable size according to its contents"
                    
                ]
            ],
            [
                "label" => "bii",
                "text" => "Explain, giving an example, why the firm’s computers use operating systems capable of multi-tasking.",
                "type" => "OE",
                "marks" => 4,
                "mark_schemes" => [
                    "Paging",
                    "Memory is divided into fixed/physical units",
                    "Segmentation",
                    "Memory is divided logically/variable size according to its contents"
                    
                ]
                
            ],
            [
                "label" => "ci",
                "text" => "The computers in the office are connected to a LAN which is connected to the Internet.
                The LAN is set up in a client-server network. Give one advantage to the architects’ firm of a client-server set up rather than a peer to peer setup. ",
                "type" => "OE",
                "marks" => 1,
                "mark_schemes" => [
                    "Centrally administered in one location",
                    "One location to back up",   
                ]
                
            ],
            [
                "label" => "cii",
                "text" => "one disadvantage to the architects’ firm of a client-server set up rather than a peer to peer setup ",
                "type" => "OE",
                "marks" => 1,
                "mark_schemes" => [
                    "Central point of failure",
                    "Can be expensive to maintain/set up",   
                ]
                
            ],
            [
                "label" => "ciii",
                "text" => "The LAN is connected to the Internet via a firewall. Describe the term ‘firewall’.",
                "type" => "MC",
                "marks" => 1,
                "options" => [
                    ["text" => "Block all data", "is_correct" => 0],
                    ["text" => "A hardware device or piece of software that monitors traffic/packets going to and from a network.", "is_correct" => 1],
                    ["text" => "A hardware device or software device that encapsulates your computer from the outside world ", "is_correct" => 0],
                    ["text" => "to provide a vacine for your computer", "is_correct" => 0],
                ]
            ],
            [
                "label" => "civ",
                "text" => "State why the architects’ firm would use a firewall.",
                "type" => "OE",
                "marks" => 1,
                "mark_schemes" => [
                    "Prevent unauthorised access to a network",
                    "To restrict applications that are used internally that have internet access",
                    "To restrict websites that can be accessed from within the company",
                    "To protect the company’s data/intellectual property"
                    
                ]
            ],
    ] ,
    [ 
        "text" => "A coach company offers tours of the UK ",
        "type" => "OE",
        "marks" => 11,
        "parts" => [
            
                "label" => "ai",
                "text" => "A linked list stores the names of cities on a coach tour in the order they are visited",
                "type" => "OE",
                "marks" => 3,
                "diagram" => "q2 ai linked list.JPG",
                "mark_schemes" =>[ 
                    "To render models of proposed buildings",
                    "Run CAD software",
                    "Run modelling calculations."
                    
                ]
        ],
        [
            "label" => "aii",
            "text" => "The tour is amended. The new itinerary is: London, Oxford, Manchester then York. Explain how Birmingham is removed from the linked list and how York is added.",
            "type" => "OE",
            "marks" => 4,
            "mark_schemes" => [
                "Oxford pointer changed to bypass Birmingham and point to Manchester",
                "A node is created holding the data York/York is placed is next free space/node/item",
                "Manchester remains in original position and pointer changed to point to the York node",
                " The York node points to null "
                
            ]
        ],
        [
            "label" => "b",
            "text" => "Often an individual customer’s record needs to be accessed. This is done by searching using the Customer ID. Explain why a hash table is better suited than a linked list to store the customer records, particularly as the company acquires more customers.",
            "type" => "OE",
            "marks" => 4,
            "mark_schemes" => [
                "A linked list requires every node to be checked (until the desired record is found",
                "A linked list will take longer to search (as more nodes are added)",
                "A hash table enables direct access to the location of the record",
                "A hash table will take the same time to search (as more nodes are added)/It takes no longer as more records are added  "
                
            ]
        ],
    ],
    [
        "text" => "A charitable organisation is trying to make the works of William Shakespeare available to more people ",
        "type" => "OE",
        "marks" => 4,
        "parts" => [
            "label" => "ai",
                "text" => "The organisation decides to make a copy of Shakespeare’s entire works available as adownloadable text file from its website. It further decides to compress the file before making itavailable to download.",
                "type" => "MC",
                "marks" => 1,
                "options" => [
                    ["text" => "makes the file look more tidy", "is_correct" => 0],
                    ["text" => "helps the user to read the file faster", "is_correct" => 0],
                    ["text" => "Downloads quicker ", "is_correct" => 1],
                    ["text" => "Saves user money by using less bandwidth", "is_correct" => 1],
                ]
            ],
            [
                "label" => "aii",
                "text" => "Explain why the company should use lossless and not lossy compression",
                "type" => "OE",
                "marks" => 3,
                "mark_schemes" => [
                    "Lossy takes away some of the information from the original",
                    "Lossless preserves all the information from the original",
                    "With text the loss of small amounts of information will make it unreadable.",
                ]
            ],
        ],
    [
        "text" => "A cinema offers discounted tickets, but only under one of the following conditions: Customer is under 18 and has a student card ,Customer is over 60 and has ID which proves this.",
        "type" => "MC",
        "marks" => 5,
        "parts" =>[
            "label" => "ai",
                "text" => "A be Customer is under 18, B be Customer has a student card, C be Customer is over 60, D be Customer has ID, Q be Discount ticket issued.",
                "type" => "MC",
                "marks" => 3,
                "options" => [
                    ["text" => "(A∨B) ∧ (C∨D)", "is_correct" => 0],
                    ["text" => "(A∧B) ∨ (C∧D)", "is_correct" => 0],
                    ["text" => "(A∨B) ∧ (C∧D) ", "is_correct" => 0],
                    ["text" => "(A∧B) ∨ (C∧D)", "is_correct" => 1],
                ]
        ],
        [
            "label" => "aii",
            "text" => "Simplify the expression, (E∧F) ∨ (E∧G) .",
            "type" => "MC",
            "marks" => 2,
            "options" => [
                ["text" => "(E∨G) ∧ F", "is_correct" => 0],
                ["text" => "(F∨G) ∧ E", "is_correct" => 1],
                ["text" => "(F∨E) ∧ G", "is_correct" => 0],
                ["text" => "(F∨G) ∨ E", "is_correct" => 0],
            ]
        ],
        [
            "label" => "b",
            "text" => "Describe one technical measure the studio could use to ensure that films are not shown early.",
            "type" => "MC",
            "marks" => 2,
            "options" => [
                ["text" => "send the wrong film at first befor sending out the right one", "is_correct" => 0],
                ["text" => "Encrypt the film", "is_correct" => 1],
                ["text" => "Send the key/password out on the release date", "is_correct" => 1],
                ["text" => "send the cinema the kay and film together at the same time", "is_correct" => 0],
            ]
        ],
    ]
    [
        "text" => "Below is part of a program written using the Little Man Computer instruction set. This section of code can exit by either jumping to the code labelled pass or fail depending on what value is in the accumulator when the code is run.",
        "type" => "MC",
        "marks" => 5,
        "parts" =>[
            "label" => "ai",
                "text" => "Explain what the line ten DAT 10 does.",
                "type" => "MC",
                "marks" => 2,
                "diagram" => "q5-ai.jpg",
                "options" => [
                    ["text" => "(A∨B) ∧ (C∨D)", "is_correct" => 0],
                    ["text" => "(A∧B) ∨ (C∧D)", "is_correct" => 0],
                    ["text" => "(A∨B) ∧ (C∧D) ", "is_correct" => 0],
                    ["text" => "(A∧B) ∨ (C∧D)", "is_correct" => 1],
                ]
        ]
    ]            
];

foreach ($questions as $q) {
    $question_text = $conn->real_escape_string($q["text"]);
    $total_marks = $q["marks"];
    $question_type = $q["type"];

    // Insert main question
    $insert_question_sql = "INSERT INTO questions (paper_id, question_text, question_type, total_marks) VALUES 
                            ($paper_id, '$question_text', '$question_type', $total_marks)";
    if ($conn->query($insert_question_sql) === TRUE) {
        $question_id = $conn->insert_id;

        // Insert each part of the question
        foreach ($q["parts"] as $part) {
            $part_label = $conn->real_escape_string($part["label"]);
            $part_text = $conn->real_escape_string($part["text"]);
            $part_type = $part["type"];
            $part_marks = $part["marks"];

            $insert_part_sql = "INSERT INTO question_parts (question_id, part_label, part_text, part_type, part_marks) VALUES 
                                ($question_id, '$part_label', '$part_text', '$part_type', $part_marks)";
            if ($conn->query($insert_part_sql) === TRUE) {
                $part_id = $conn->insert_id;

                // Add multiple mark schemes for open-ended questions
                if ($part_type == "OE" && !empty($part["mark_schemes"])) {
                    foreach ($part["mark_schemes"] as $scheme) {
                        $correct_answer = $conn->real_escape_string($scheme);
                        $insert_scheme_sql = "INSERT INTO mark_schemes (part_id, correct_answer) VALUES ($part_id, '$correct_answer')";
                        $conn->query($insert_scheme_sql);
                    }
                }

                // Add options for multiple-choice parts
                if ($part_type == "MC" && !empty($part["options"])) {
                    foreach ($part["options"] as $opt) {
                        $option_text = $conn->real_escape_string($opt["text"]);
                        $is_correct = $opt["is_correct"];
                        $insert_option_sql = "INSERT INTO options (part_id, option_text, is_correct) VALUES ($part_id, '$option_text', $is_correct)";
                        $conn->query($insert_option_sql);
                    }
                }
            }
        }
    }
}

$conn->close();
?>
