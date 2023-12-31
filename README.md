# prototype-spritemaths

Visit <a href="https//spritemaths.com" target="_blank">spritemaths.com</a>

As a guest use these credentials:
email: nillad12@gmail.com
password: dallin

## Inspiration

While I was studying at university I was inspired by the Maths department's assignment marking system. Each week all of the students would get an assignment and by the end of it the computer would mark it.

I wanted to do something similar but for NCEA.

I used Mossadal's PHP parser and evaluator library for mathematical expressions to mark the submitted answers. Here is a link to his github page:

For complete documentation, see the [github.io project page](http://mossadal.github.io/math-parser/index.html)

## About the project

![Alt text](./readme-images/landingpage.png 'Landing Page')

^^This is the landing page. CSS styling isn't perfect and it definitely isn't appropriate for viewing on a phone.

![Alt text](./readme-images/menupage.png 'Menu Page')

^^This is the menu page. It contains a list of all the types of tests a student could take sorted by year and topic.

![Alt text](./readme-images/quizpage.png 'Quiz Page')

^^This is the quiz page. Styling is done via MathQuill API. See here for their documentation: <a href="http://mathquill.com" target="_blank">MathQuill</a>. Students can type in their responses. They have the option of saving their test to finish it off later or submit it for marking.

![Alt text](./readme-images/markingpage.png 'Marking Page')

^^This is the marking page. Using the PHP parser and evaluator library student's answers get compared to the correct suggested answers. I should do more to prevent students from inputting a silly correct answer. Such as the expression that exists in the question. For example: Simplify 2x^2 + 3x + 5x. A student could just input this expression in the answer box. Both are mathematically correct however the question asked for simplification so the correct answer would be: 2x^2 + 8x. I'll have to figure out how to fix this.
