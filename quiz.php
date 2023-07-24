<?php
    if(!isset($_POST['fname'])){
        header("Location: index.php");
        exit();
    }
    session_start();
    require 'Header/header.php';
    require 'includes/testcodes.inc.php';
    require 'includes/Database/dbh.inc.php';
    require 'includes/Question.class.php';

    //dimensions of canvas for quesiton image
    $questionImageDimensions = array("height"=>400,"width"=>400);

    $newtest = '';
    $newtestCapitalized = '';
    $testid = '';
    if(isset($_POST['newtest'])){
        $createdByTutor = 0;
        $newtest = $_POST['newtest'];
        require 'includes/TestManager/test_manager.inc.php';
        require 'includes/SavingTests/savenewtest.inc.php';
    } else if(isset($_POST['savedtest'])){
        $testid = $_POST['savedtest'];
    }

    if(isset($_POST['newexam'])){
        $createdByTutor = 0;
        $newtest = $_POST['newexam'];
        require 'includes/TestManager/exam_manager.inc.php';
        require 'includes/SavingTests/savenewtest.inc.php';
    } else if(isset($_POST['savedexam'])){
        $testid = $_POST['savedexam'];
    }

    $_SESSION['testID'] = $testid;

    //once I get all the information for the test I need to check whether its a test that has been sent to the tutor
    require 'includes/LoadTests/quiz_loadtest.inc.php';

    $questionBlurb = $questionBlurbs[$question_num];
    $question = $questions[$question_num];

    //fetch all of the users available tutors
    $tutorsIDArray = [];
    $tutorsNameArray = [];

    $accepted=1;
    $sql = "SELECT idTutor FROM tutorstudentrelations WHERE (idStudent,accepted)=(?,?);";
    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: Requests/requests.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ii", $_SESSION['userId'], $accepted);
    mysqli_stmt_execute($stmt);
    $result1 = mysqli_stmt_get_result($stmt);
    while($row1 = mysqli_fetch_assoc($result1)){
        array_push($tutorsIDArray, $row1['idTutor']);
        $sql = "SELECT firstName,lastName FROM users WHERE idUsers=?;";
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: Requests/requests.php?error=sqlerror");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "i", $row1['idTutor']);
        mysqli_stmt_execute($stmt);
        $result2 = mysqli_stmt_get_result($stmt);
        while($row2 = mysqli_fetch_assoc($result2)){
            array_push($tutorsNameArray, $row2['firstName'].' '.$row2['lastName']);
        }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Quiz Page</title>

        <link rel="stylesheet" href="quiz_style.css?<?php echo time(); ?>"/> 
        <link rel="icon" type="image/x-icon" sizes="256x256" href="images/faviconSpriteMaths256.ico">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> 
        <script src="https://cdnjs.cloudflare.com/ajax/libs/mathquill/0.10.1/mathquill.js"></script>   
        <script src="ace-builds-master/src/ace.js" type="text/javascript" charset="utf-8"></script>
        <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
        <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
        <script>
            $(document).ready(function() {
                setTimeout(function() {
                    $(".loader-screen").hide();
                }, 2500);

                //the ace editor
                var editor = ace.edit("ecode");
                //the question blurbs
                var questionblurbs = <?php echo json_encode($questionBlurbs);?>;
                //the questions
                var questions = <?php echo json_encode($questions);?>;  
                //the index for questions              
                var questionnum = <?php echo $question_num;?>;      
                //the submitted answers             
                var inputanswers = <?php echo json_encode($submittedanswers);?>; 
                //the submitted workings
                var inputworkings = <?php echo json_encode($submittedworkings);?>;
                //logicalReasoningPoints
                var logicalreasoningpoints = <?php echo json_encode($logicalReasoningPoints);?>;
                //addresses for the images
                var imagerefs = <?php echo json_encode($imagereferences);?>;
                //the actual question number (not index)
                var questionnumv = questionnum + 1; 
                //the total number of questions                             
                var numquestions = questions.length;   

                const btnNextQuestion = document.getElementById('ns');
                const btnPreviousQuestion = document.getElementById('ps');
                const btnSaveTest = document.getElementById('se');
                const btnSubmitMark = document.getElementById('ms');
                const btnSendBack = document.getElementById('sb');
                <?php 
                //if there exists any tutors to display run this code
                if(count($tutorsIDArray)!=0&&!$markedByTutor){
                    echo 'const btnSendTutor = document.getElementById("st");';

                    echo    'btnSendTutor.addEventListener("click", () =>  {
                                sendToTutor();
                                saveTest();
                            });';

                    echo    'function sendToTutor()
                            {
                                var tutorID = document.getElementById("tutor-list").value;
                                var sendToTutor = 1;
            
                                $.post({
                                    url: "includes/SavingTests/sendtotutor.inc.php",
                                    data: {sent: sendToTutor,
                                            tutor: tutorID},
                                    success  :  function(data,xhr,req) {
                                        if (req.status == 200) {
                                            //alert("Successfl");
                                            //window.location.replace("../HomeScreen/home.php");
                                        } else {
                                            //alert("Unsuccessful");
                                        }
                                    }   
            
                                })
                            }';
                }
                ?>

                const qnumDisplay = document.getElementById('qnumdisplay'); 
                const imageDisplay = document.getElementById('image');
                const blurbDisplay = document.getElementById('qblurb');

                const btnNotesVisibility = document.getElementById('nv');

                const questionImageSVGDiv = document.getElementById('sq');

                const logicalReasoningPointsDiv = document.getElementById('logicalpoints');

                btnNextQuestion.addEventListener('click', () =>  {
                    nextQuestion();
                });

                btnPreviousQuestion.addEventListener('click', () =>  {
                    previousQuestion();
                });
                
                
                btnSaveTest.addEventListener('click', () =>  {
                    saveTest();
                });
                
                btnSubmitMark.addEventListener('click', () =>  {
                    markTest();
                });

                btnNotesVisibility.addEventListener('click', () =>  {
                    updateAceEditorVisibility();
                });

                btnSendBack.addEventListener('click', ()=> {
                    sendToStudent();
                    saveTest();
                });

            
                function sendToStudent()
                {
                    var markedByTutor = 1;

                    $.post({
                        url: "includes/SavingTests/sendtostudent.inc.php",
                        data: {marked: markedByTutor},
                        success  :  function(data,xhr,req) {
                            if (req.status == 200) {
                                //alert("Successfl");
                                //window.location.replace("../HomeScreen/home.php");
                            } else {
                                //alert("Unsuccessful");
                            }
                        }   

                    })
                }
                
                function updateAceEditorVisibility()
                {
                    var editorClass = document.getElementById("ec")
                    if (editorClass.style.display === "none") {
                        editorClass.style.display = "block";
                    } else {
                        editorClass.style.display = "none";
                    }
                }
                

                function updateAceEditor(questionnum, previousnum)
                {
                    var previousworking;

                    editor.selectAll();
                    previousworking = editor.getCopyText();
                    editor.insert('');
                    editor.insert(inputworkings[questionnum]);

                    inputworkings[previousnum] = previousworking;
                }
                    

                function nextQuestion() 
                {
                    if(questionnum+1<questions.length){
                        //grab the written answer
                        var inputanswer = mathField.latex();
                        //grab the logicalReasoningPoints
                        var logicalpoint = logicalreasoningpoints[questionnum];

                        if(logicalReasoningPointsDiv!=null){
                            //confirm(logicalpoint);
                            logicalpoint = logicalReasoningPointsDiv.value;
                        } //Here is the problem for nontutor tests
                        //save
                        logicalreasoningpoints[questionnum] = logicalpoint;
                        //save it in the inputanswers array
                        inputanswers[questionnum] = inputanswer; 
                        //delete the written answer
                        mathField.select();
                        //since we are moving to the next question increase the questionnum by 1
                        questionnum = questionnum + 1; 
                        //the new question to appear
                        question = questions[questionnum];
                        //the new questionblurb to appear
                        questionblurb = questionblurbs[questionnum];
                        //the new question number to appear
                        questionnumv = questionnum + 1;   

                        qnumDisplay.innerHTML = "Question "+questionnumv+"/"+numquestions+":<br>";
                        
                        //disable the previous question button or the next question button if we reach corresponding ends
                        if(questionnumv == questions.length){
                            btnNextQuestion.disabled = true;
                        } else if (questionnumv == 1){
                            btnPreviousQuestion.disabled = true;
                        } else {
                            btnNextQuestion.disabled = false;
                            btnPreviousQuestion.disabled = false;
                        }

                        mathField.write(inputanswers[questionnum]);//put in the saved input for the next question
                        mathField.focus();//get the blinking focus icon iside the box
                        questionField.latex(question); //render the question in latex form for the answer box
                        updateBlurb(questionnum);

                        

                        if(imagerefs[questionnum]!=''){
                            const xhttp = new XMLHttpRequest();
                            xhttp.open("GET", imagerefs[questionnum]);
                            xhttp.send();
                            xhttp.onreadystatechange = function() {
                                if(this.readyState == 4 && this.status == 200){
                                    MathJax.typesetClear();
                                    questionImageSVGDiv.innerHTML = this.responseText;
                                    questionImageSVGDiv.style.display = 'inline';
                                    MathJax.typeset();
                                }
                            };
                        } else {
                            questionImageSVGDiv.innerHTML = '';
                            questionImageSVGDiv.style.display = 'none';
                        }

                        updateAceEditor(questionnum, questionnum - 1);

                        //change the selected options for the logicalreasoningpoints
                        var innerHTMLPoints = '';
                        for(let i=0; i<logicalreasoningpoints.length+1; i++ ){
                            if(logicalreasoningpoints[questionnum]==i){
                                innerHTMLPoints += '<option selected="selected" value="';
                                innerHTMLPoints += i;
                                innerHTMLPoints +='">';
                                innerHTMLPoints +=i;
                                innerHTMLPoints +='</option>';
                            } else {
                                innerHTMLPoints += '<option value="';
                                innerHTMLPoints += i;
                                innerHTMLPoints +='">';
                                innerHTMLPoints += i;
                                innerHTMLPoints +='</option>';
                            }
                        }
                        if(logicalReasoningPointsDiv!=null){
                            logicalReasoningPointsDiv.innerHTML = innerHTMLPoints;
                        }
                    }
                }

                function previousQuestion() 
                {
                    if(questionnum>0){
                        var inputanswer = mathField.latex();
                        var logicalpoint = logicalreasoningpoints[questionnum];

                        if(logicalReasoningPointsDiv!=null){
                            logicalpoint = logicalReasoningPointsDiv.value;
                        }
                        //save
                        logicalreasoningpoints[questionnum] = logicalpoint; //Here is the problem for nontutor tests
                        inputanswers[questionnum] = inputanswer;
                        mathField.select();

                        questionnum = questionnum - 1;
                        question = questions[questionnum];
                        questionblurb = questionblurbs[questionnum];
                        questionnumv = questionnum + 1;

                        qnumDisplay.innerHTML = "Question "+questionnumv+"/"+numquestions+":<br>";
                        
                        //disable the previous question button or the next question button if we reach corresponding ends
                        if(questionnumv == questions.length){
                            btnNextQuestion.disabled = true;
                        } else if (questionnumv == 1){
                            btnPreviousQuestion.disabled = true;
                        } else {
                            btnNextQuestion.disabled = false;
                            btnPreviousQuestion.disabled = false;
                        }

                        mathField.write(inputanswers[questionnum]);//put in the saved input for the next question
                        mathField.focus();//get the blinking focus icon iside the box
                        questionField.latex(question); //render the question in latex form for the answer box
                        updateBlurb(questionnum);

                        if(imagerefs[questionnum]!=''){
                            const xhttp = new XMLHttpRequest();
                            xhttp.open("GET", imagerefs[questionnum]);
                            xhttp.send();
                            xhttp.onreadystatechange = function() {
                                if(this.readyState == 4 && this.status == 200){
                                    MathJax.typesetClear();
                                    questionImageSVGDiv.innerHTML = this.responseText;
                                    questionImageSVGDiv.style.display = 'inline';
                                    MathJax.typeset();
                                }
                            };
                        } else {
                            questionImageSVGDiv.innerHTML = '';
                            questionImageSVGDiv.style.display = 'none';
                        }

                        updateAceEditor(questionnum, questionnum + 1);

                        //change the selected options for the logicalreasoningpoints
                        var innerHTMLPoints = '';
                        for(let i=0; i<logicalreasoningpoints.length+1; i++ ){
                            if(logicalreasoningpoints[questionnum]==i){
                                innerHTMLPoints += '<option selected="selected" value="';
                                innerHTMLPoints += i;
                                innerHTMLPoints +='">';
                                innerHTMLPoints +=i;
                                innerHTMLPoints +='</option>';
                            } else {
                                innerHTMLPoints += '<option value="';
                                innerHTMLPoints += i;
                                innerHTMLPoints +='">';
                                innerHTMLPoints += i;
                                innerHTMLPoints +='</option>';
                            }
                        }

                        if(logicalReasoningPointsDiv!=null){
                            logicalReasoningPointsDiv.innerHTML = innerHTMLPoints;
                        }
                    }
                }

                function saveTest() 
                {
                    editor.selectAll();
                   
                    var inputanswer = mathField.latex();
                    var previousworking = editor.getCopyText();
                    var logicalpoint = 0;

                    if(logicalReasoningPointsDiv!=null){
                        logicalpoint = logicalReasoningPointsDiv.value;
                    } else {
                        logicalpoint = logicalreasoningpoints[questionnum];
                    }
                    
                    inputanswers[questionnum] = inputanswer;
                    inputworkings[questionnum] = previousworking;
                    logicalreasoningpoints[questionnum] = logicalpoint;

                    $.post({
                        url: "includes/SavingTests/savetest.inc.php",
                        data: {inputa: inputanswers, inputw: inputworkings, logicalrp: logicalreasoningpoints},
                        success  :  function(data,xhr,req) {
                            if (req.status == 200) {
                                //alert('Successfull');
                                window.location.replace("home.php");
                            } else {
                                //alert('Unsuccessful');
                            }
                        }

                    })
                }


                function markTest()
                {
                    var inputanswer = mathField.latex();
                    var previousworking = editor.getCopyText();
                    var logicalpoint = 0;

                    if(logicalReasoningPointsDiv!=null){
                        logicalpoint = logicalReasoningPointsDiv.value;
                    } else {
                        logicalpoint = logicalreasoningpoints[questionnum];
                    }

                    inputanswers[questionnum] = inputanswer;
                    inputworkings[questionnum] = previousworking;
                    logicalreasoningpoints[questionnum] = logicalpoint;
                    
                    $.post({
                        url: "includes/SavingTests/savetest.inc.php",
                        data: {inputa: inputanswers, inputw: inputworkings, logicalrp: logicalreasoningpoints},
                        success  :  function(data,xhr,req) {
                            if (req.status == 200) {
                                //alert('Successful');
                                window.location.replace("testsummary.php");
                            } else {
                                //alert('Unsuccessful');
                            }
                        }
                    })
                }

                function updateBlurb(questionnum){
                    var innerHTMLLine = '';
                    for(let i = 0; i < questionblurbs[questionnum].length; i++){
                        innerHTMLLine += '<div id ="qblurbline';
                        innerHTMLLine += i;
                        innerHTMLLine += '" style="font-size:18px">';
                        innerHTMLLine += questionblurbs[questionnum][i];
                        innerHTMLLine += '</div>';
                    }
                    blurbDisplay.innerHTML = innerHTMLLine;
                    for(let i = 0; i < questionblurbs[questionnum].length; i++){
                        var questionBlurbLineFieldSpani = document.getElementById('qblurbline'+i);
                        var MQ2blurbi = MathQuill.getInterface(2);
                        var questionBlurbLineFieldi = MQ2blurbi.StaticMath(questionBlurbLineFieldSpani);
                    }
                }

                var mathFieldSpan = document.getElementById('ans');

                var MQ1 = MathQuill.getInterface(2);
                var mathField = MQ1.MathField(mathFieldSpan, {
                    spaceBehavesLikeTab: true, // configurable
                    supSubsRequireOperand: true,
                    autoCommands: 'pi sqrt',
                    //autoOperatorNames: '',
                    handlers: {
                        edit: function() { // useful event handlers
                        }
                    }
                });

                mathField.focus();

                var questionFieldSpan = document.getElementById('qdisplay');
                var MQ2 = MathQuill.getInterface(2); 
                var questionField = MQ2.StaticMath(questionFieldSpan);

                //var questionBlurbFieldSpan = document.getElementById('qblurb');
                //var MQ2blurb = MathQuill.getInterface(2); 
                //var questionBlurbField = MQ2blurb.StaticMath(questionBlurbFieldSpan);

                btnPreviousQuestion.disabled = true;

                editor.selectAll();
                editor.insert('');
                editor.insert(inputworkings[questionnum]);
                //$('.ace_text-input').style.color = 'red';
            })

        </script>
    </head>

    <body>
        <div class="loader-screen">
        <div class="loader-animation">
        </div>
        </div>
        <div class="question-container" id ="qc">
            <div class="question-title">
                <?php echo $testTypes;?>
            </div>
            <div id="qnumdisplay" class="question-question">
                <?php   
                    echo 'Question '.($question_num+1).'/';
                    echo $num_questions;
                    echo ':';
                    echo "<br>";
                ?>
            </div>
            <div id="qblurb" style="">
                <?php
                for($i = 0; $i < count($questionBlurb);$i++){
                    echo '<div id = "qblurbline'.$i.'" style="font-size:18px">'.$questionBlurb[$i].'</div>';
                    echo '<script>
                            var questionBlurbLineFieldSpan'.$i.' = document.getElementById("qblurbline'.$i.'");
                            var MQ2blurb'.$i.' = MathQuill.getInterface(2);
                            var questionBlurbLineField = MQ2blurb'.$i.'.StaticMath(questionBlurbLineFieldSpan'.$i.');
                         </script>';
                }
                ?>
            </div>
            <div id = "qi" class="question-image">
            
            <?php 
                if($imagereferences[$question_num]!=''){
                    echo '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" id = "sq" width="'.$questionImageDimensions["width"].'" height ="'.$questionImageDimensions["height"].'">';
                    $imageSVG = fopen($imagereferences[$question_num], "r");
                    echo fread($imageSVG, filesize($imagereferences[$question_num]));
                    echo '</svg>';
                } else {
                    echo '<svg id = "sq" width="'.$questionImageDimensions["width"].'" height ="'.$questionImageDimensions["height"].'" style="display: none">';
                    echo '</svg>';
                }
            ?>
            
            </div>
            <div id="qdisplay" class="question-question">
                <?php echo $question; ?>
            </div>
            <div class="question-answer">
                <span class= "submission-box" id="ans"><?php echo $submittedanswers[$question_num]; ?></span>
            </div>
            <div class="otherbuttons">
                <button type="submit" id = "ps" name="previous-submit" title="Previous Question"></button>
                <button type="submit" id = "ns" name="next-submit" title="Next Question"></button>
            </div>
            <div class="tutor">
                <?php
                if(count($tutorsIDArray)!=0&&!$markedByTutor){
                    echo '<button type="submit" id = "st" name="send-tutor">Save and Send To Tutor</button>';
                    echo '<select id="tutor-list" name="tutors">';
                    for($i=0; $i<count($tutorsIDArray); $i++){
                        echo '<option value="'.$tutorsIDArray[$i].'">'.$tutorsNameArray[$i].'</option>';
                    }
                    echo '</select>';
                }
                ?>
            </div>
            <div class="logicalPoints">
                <?php
                    if($sentToTutor&&!$markedByTutor&&$idTutor==$_SESSION['userId']){
                ?>
                <select id="logicalpoints" name="points">
                    <?php
                        for($i=0; $i<6;$i++){
                            if($logicalReasoningPoints[0]==$i){
                                echo '<option value="'.$i.'" selected="selected">'.($i).'</option>';
                            } else {
                                echo '<option value="'.$i.'">'.($i).'</option>';
                            }
                        }
                    ?>
                </select>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="finish">
            <button type="submit" id = "se" name="save-exit" title="Save and Exit"></button>
            <?php if($sentToTutor==1&&$markedByTutor==0&&$idTutor==$_SESSION['userId']){ ?>
                <button type="submit" id = "ms" name="mark-submit" style="display: none" title="Submit and Mark"></button>
                <button type="submit" id = "sb" name="send-back">Send Back to Student</button>
            <?php } else { ?>
                <button type="submit" id = "ms" name="mark-submit" title="Submit and Mark"></button>
                <button type="submit" id = "sb" name="send-back" style="display: none">Send Back to Student</button>
            <?php } ?> <!-- I won't worry about security here because the tutor can do what they want, but I think I need to look into security issues on the student side--> 
        </div>

        <button type="submit" id ="nv" name="notes-visibility">Toggle Notes</button>
        
        <div id="ec" class="editor" style="display:none">
            <div class="editor__wrapper">
                <div class="editor__code" id ="ecode">
                </div>
            </div>
        </div>

    </body>
</html>