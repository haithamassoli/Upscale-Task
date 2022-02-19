const submit_Button = document.querySelector(".submit-btn");
const question = document.querySelector(".question");
const allAnswers = document.querySelector(".all-answers");
const spans = document.querySelector(".spans");
const container = document.querySelector(".quiz-container");
const timeText = document.querySelector(".time_left_txt");
const timeCount = document.querySelector(".timer_sec");
const input = document.querySelectorAll("input");
const quizName = document.querySelector(".quiz-name");
const info_box = document.querySelector(".info_box");
const continue_btn = info_box.querySelector(".buttons .restart");
const Show_Answer = document.querySelector(".Show_Answer");
const result_box = document.querySelector(".result_box");
const score_text = document.querySelector(".score_text");
const result = document.querySelector(".result");
const time_line = document.querySelector(".time_line");
const result_img = document.querySelector(".result_img");
const footer = document.querySelector("footer");
const userId = document
    .querySelector("meta[name='user-id']")
    .getAttribute("content");
const token = document
    .querySelector("meta[name='csrf-token']")
    .getAttribute("content");

let largeDiv = document.createElement("div");
let userAnswer;
let numOfQuestion = 0;
let right_answer;
let correct = 0;
let total = 0;
let mark = 0;
let user_answers = [];
let right_answers = [];
let labelAns = [];
let options;
const questionsNum = document.querySelector(".questionsNum");

continue_btn.addEventListener("click", () => {
    info_box.classList.remove("activeInfo");
    container.classList.add("active");
    startTimer(15);
    startTimerLine(15);
});

let link = window.location.href.split("/");
let exam_id = link.slice(-1)[0];

Show_Answer.addEventListener("click", () => {
    done();
    window.open(`/result/${exam_id}`, "_self");
    result_box.classList.remove("activeResult");
    container.classList.add("active");
    footer.classList.remove("active");
});
function loadQuestions(number) {
    fetch(`http://127.0.0.1:8000/api/exam/${exam_id}`)
        .then((response) => response.json())
        .then((data) => {
            if (number < data[0].exam_num_qus) {
                mark += localStorage.getItem("question_point");
                quizName.innerHTML = data[0].exam_name;
                localStorage.setItem("exam_num_qus", data[0].questions.length);
                localStorage.setItem(
                    "question_id",
                    data[0].questions[number].id
                );
                localStorage.setItem(
                    "question_point",
                    data[0].questions[number].question_point
                );
                options = data[0].questions[number].question_options;
                addQuestion(
                    options,
                    data[0].questions[number].question_content
                );
                createBullets(number);
                right_answer = data[0].questions[number].correct_answer;
            }
        });
}
loadQuestions(numOfQuestion);

submit_Button.addEventListener("click", () => {
    checkRightAnswer(right_answer);
    numOfQuestion++;
    reset();
    loadQuestions(numOfQuestion);
    if (numOfQuestion > localStorage.getItem("exam_num_qus") - 1) {
        container.classList.remove("active");
        result_box.classList.add("activeResult");
        numOfQuestion = 0;
        clearInterval(counter);
        clearInterval(counterLine);
    }
    if (numOfQuestion == localStorage.getItem("exam_num_qus") - 1) {
        submit_Button.textContent = "Submit";
    }
    clearInterval(counter);
    clearInterval(counterLine);
    startTimer(15);
    startTimerLine(15);
});

function createBullets(numOfQuestion) {
    for (let i = 0; i <= localStorage.getItem("exam_num_qus") - 1; i++) {
        const span = document.createElement("span");
        spans.appendChild(span);
        if (i === numOfQuestion) {
            span.classList.add("active-question");
        }
    }
}

function addQuestion(arrayOfOptions, number_of_question) {
    const questionText = document.createElement("h2");
    questionText.innerHTML = number_of_question;
    question.appendChild(questionText);
    for (let i = 0; i <= arrayOfOptions.split(",").length - 1; i++) {
        const answer = document.createElement("div");
        answer.classList.add("answer");
        const input = document.createElement("input");
        input.name = "answer";
        input.type = "radio";
        input.className = "inputRadio";
        input.id = `answer${i}`;
        const label = document.createElement("label");
        label.setAttribute("for", `answer${i}`);
        let options_split = arrayOfOptions.split(",");
        label.textContent = options_split[i];
        answer.appendChild(input);
        answer.appendChild(label);
        allAnswers.appendChild(answer);
    }
}

function checkRightAnswer(correct_answer) {
    const inputAnswers = document.querySelectorAll("input");
    let userAnswer;
    inputAnswers.forEach((input) => {
        if (input.checked) {
            userAnswer = input.nextElementSibling.innerHTML;
            store_user_answer(userAnswer);
            right_answers.push(correct_answer);
            user_answers.push(userAnswer);
            if (userAnswer !== correct_answer) {
            } else {
                total += localStorage.getItem("question_point");
                correct = localStorage.getItem("question_point");
            }
        }
    });
    score_text.style.color = "green";
    result_img.src = "/img/good.jpg";
}

function reset() {
    allAnswers.innerText = "";
    spans.innerText = "";
    question.innerText = "";
    userAnswer = "";
    right_answer = "";
}

function startTimer(time) {
    counter = setInterval(timer, 1000);
    function timer() {
        timeCount.textContent = time;
        time--;
        if (time < 9) {
            let addZero = timeCount.textContent;
            timeCount.textContent = "0" + addZero; //add a 0 before time value
        }
        if (time < 0) {
            clearInterval(counter);
            clearInterval(counterLine); //clear counter
            reset();
            numOfQuestion++;
            loadQuestions(numOfQuestion);
            startTimer(15);
            startTimerLine(15);

            numOfQuestion > localStorage.getItem("exam_num_qus") - 1
                ? window.open(`/result/${exam_id}`, "_self")
                : "";
        }
    }
}
function startTimerLine(time) {
    counterLine = setInterval(timer, 29);

    function timer() {
        time += 1; //upgrading time value with 1
        time_line.style.width = time * 0.1821 + "%"; //increasing width of time_line with px by time value
        if (time > 100 + "%") {
            //if time value is greater than 549
            clearInterval(counterLine); //clear counterLine
        }
    }
}

// post date to database

function store_user_answer(userAnswer) {
    fetch("http://127.0.0.1:8000/api/exam/create", {
        method: "POST",
        headers: {
            "Content-type": "application/json",
        },
        body: JSON.stringify({
            exam_id: parseInt(exam_id),
            user_id: parseInt(userId),
            question_id: parseInt(localStorage.getItem("question_id")),
            user_answer: userAnswer,
            marks: correct,
        }),
    })
        .then((res) => res.json())
        .then(() => location.reload);
}

function done() {
    fetch("http://127.0.0.1:8000/api/exam/done", {
        method: "POST",
        headers: {
            "Content-type": "application/json",
        },
        body: JSON.stringify({
            exam_id: parseInt(exam_id),
            user_id: parseInt(userId),
        }),
    })
        .then((res) => res.json())
        .then(() => location.reload);
}
