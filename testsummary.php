<!-- 
    16-02-22
    Added the try catch feature. Now I feel a lot more confident about getting the website live because the parsing won't be a problem now. 
    I can focus on adding more questions and then increasing the interpreter's capacity incrementally.

    I need to add the ability for the marking algorithm to mark (x,y) coordinate answers

-->
<?php
    if(!isset($_POST['fname'])){
        header("Location: index.php");
        exit();
    }
    session_start();
    //The case when an array of answers contains a mixture of expressions and equations. Will I ever need this though? It would be good to have it generalized so that if it detects "," it can mark either equations or expressions
    //List of scripts needed to run Math-Parser by mossadal from GitHub
    require 'math-parser-master/src/MathParser/Interpreting/Visitors/Visitable.php';
    require 'math-parser-master/src/MathParser/Interpreting/Visitors/Visitor.php';
    require 'math-parser-master/src/MathParser/Interpreting/Evaluator.php';
    require 'math-parser-master/src/MathParser/Interpreting/ComplexEvaluator.php';
    require 'math-parser-master/src/MathParser/Interpreting/ASCIIPrinter.php';

    require 'math-parser-master/src/MathParser/Parsing/Stack.php';

    require 'math-parser-master/src/MathParser/Extensions/Complex.php';
    require 'math-parser-master/src/MathParser/Extensions/Rational.php';
    require 'math-parser-master/src/MathParser/Extensions/Math.php';

    require 'math-parser-master/src/MathParser/Exceptions/MathParserException.php';
    require 'math-parser-master/src/MathParser/Exceptions/UnknownVariableException.php';
    require 'math-parser-master/src/MathParser/Exceptions/UnknownTokenException.php';
    require 'math-parser-master/src/MathParser/Exceptions/SyntaxErrorException.php';
    require 'math-parser-master/src/MathParser/Exceptions/UnknownConstantException.php';
    require 'math-parser-master/src/MathParser/Exceptions/DivisionByZeroException.php';

    require 'math-parser-master/src/MathParser/Parsing/Nodes/Traits/Sanitize.php';
    require 'math-parser-master/src/MathParser/Parsing/Nodes/Node.php';
    require 'math-parser-master/src/MathParser/Parsing/Nodes/FunctionNode.php';
    require 'math-parser-master/src/MathParser/Parsing/Nodes/ConstantNode.php';
    require 'math-parser-master/src/MathParser/Parsing/Nodes/VariableNode.php';
    require 'math-parser-master/src/MathParser/Parsing/Nodes/SubExpressionNode.php';
    require 'math-parser-master/src/MathParser/Parsing/Nodes/ExpressionNode.php';
    require 'math-parser-master/src/MathParser/Parsing/Nodes/NumberNode.php';
    require 'math-parser-master/src/MathParser/Parsing/Nodes/IntegerNode.php';
    require 'math-parser-master/src/MathParser/Parsing/Nodes/RationalNode.php';
    require 'math-parser-master/src/MathParser/Parsing/Nodes/Interfaces/ExpressionNodeFactory.php';
    require 'math-parser-master/src/MathParser/Parsing/Nodes/Traits/Numeric.php';
    require 'math-parser-master/src/MathParser/Parsing/Nodes/Factories/ExponentiationNodeFactory.php';
    require 'math-parser-master/src/MathParser/Parsing/Nodes/Factories/DivisionNodeFactory.php';
    require 'math-parser-master/src/MathParser/Parsing/Nodes/Factories/MultiplicationNodeFactory.php';
    require 'math-parser-master/src/MathParser/Parsing/Nodes/Factories/SubtractionNodeFactory.php';
    require 'math-parser-master/src/MathParser/Parsing/Nodes/Factories/AdditionNodeFactory.php';
    require 'math-parser-master/src/MathParser/Parsing/Nodes/Factories/NodeFactory.php';
    require 'math-parser-master/src/MathParser/Parsing/Parser.php';
    require 'math-parser-master/src/MathParser/Lexing/Token.php';
    require 'math-parser-master/src/MathParser/Lexing/TokenType.php';
    require 'math-parser-master/src/MathParser/Lexing/TokenDefinition.php';
    require 'math-parser-master/src/MathParser/Lexing/Lexer.php';
    require 'math-parser-master/src/MathParser/Lexing/StdMathLexer.php';
    require 'math-parser-master/src/MathParser/Lexing/ComplexLexer.php';
    require 'math-parser-master/src/MathParser/AbstractMathParser.php';
    require 'math-parser-master/src/MathParser/StdMathParser.php';
    require 'math-parser-master/src/MathParser/ComplexMathParser.php';
    
    //Other scripts needed for functionality
    require 'includes/Database/dbh.inc.php';
    require 'Header/header.php';

    use MathParser\Extensions\Complex;
    use MathParser\ComplexMathParser;
    use MathParser\StdMathParser;
    use MathParser\Interpreting\Evaluator;
    use MathParser\Interpreting\ComplexEvaluator;

    if(!$_SESSION['pageReload']){
        header("Location: home.php");
        exit();
    }

    $_SESSION['pageReload'] = false;

    $score = 0;

    $userId = $_SESSION['userId'];
    $testId = $_SESSION['testID'];

    $sql = "SELECT markedByTutor, questions, imageReferences, answers, submittedAnswers, logicalReasoningPoints FROM savedtests WHERE idTests=? AND idUsers=?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: home.php?error=sqlerror");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "si", $testId, $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    $questions = unserialize(base64_decode($row['questions']));
    $imageReferences = unserialize(base64_decode($row['imageReferences']));

    $correctAnswers = unserialize(base64_decode($row['answers']));
    $submittedAnswers = unserialize(base64_decode($row['submittedAnswers']));

    $logicalReasoningPoints = unserialize($row['logicalReasoningPoints']);

    $markedByTutor = $row['markedByTutor'];

    $sql = "SELECT bronzePoints, silverPoints, goldPoints FROM users WHERE idUsers=?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: home.php?error=sqlerror");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    $bronzeP = $row['bronzePoints'];
    $silverP = $row['silverPoints'];
    $goldP = $row['goldPoints'];

    //echo $bronzeP;
    //echo $silverP;
    //echo $goldP;

    //delete the png image files for each question
    for($i = 0; $i < count($imageReferences); $i++){
        if($imageReferences[$i]!=''){
            unlink($imageReferences[$i]);
        }
    }
    
    $sql = "DELETE FROM savedtests WHERE idTests=?;";
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: home.php?error=sqlerror");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $testId);
    mysqli_stmt_execute($stmt);

?>

<!DOCTYPE html>
<html>
    <head>
        <title>deltamaths</title>

        <link rel="stylesheet" href="testsummary_style.css?<?php echo time(); ?>"/> 
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/mathquill/0.10.1/mathquill.js"></script>

        <script>
            var questions = <?php echo json_encode($questions);?>;           //the questions
            var correctAnswers = <?php echo json_encode($correctAnswers);?>; 
            var submittedAnswers = <?php echo json_encode($submittedAnswers);?>; 
        </script>
    </head>
    <body>
        <br>
        <br>
        <br>
        <br>
        <div class="test-summary">
            <div class="question-summary">

            <?php
                function divideByNegative($answer){
                    //two cases
                    //1. brackets in numerator
                    //2. no brackets in numerator
                    if (strpos($answer,")/-")){
                        $lastBracketPos = 0;
                        $count = 1;
                        $divPos = strpos($answer,")/-");
                        $index = $divPos;
                        do {
                            $index--;
                            if($answer[$index]==')'){
                                $count++;
                            } else if ($answer[$index]=='('){
                                $count--;
                            }
                        } while ($index >= 0 && $count != 0);
                        $lastBracketPos = $index;
                        $answerNoMinus = str_replace("/-","/",$answer);
                        $answerNoMinus = substr($answerNoMinus,0,$lastBracketPos).'-'.substr($answerNoMinus,$lastBracketPos);
                        return divideByNegative($answerNoMinus);

                    } else if (strpos($answer,"/-")){
                        $op = '';
                        $divPos = strpos($answer,"/-");
                        $index = $divPos;
                        do {
                            $index--;
                            if($answer[$index]=="+"||$answer[$index]=="-"||$answer[$index]=="*"){
                                $op = $answer[$index];
                            }
                        } while ($index >= 0 && $op=='');
                        $lastPos = $index;
                        if($op == "+"){
                            $answerNoMinus = str_replace("/-","/",$answer);
                            $answerNoMinus = substr($answerNoMinus,0,$lastPos).'-'.substr($answerNoMinus,$lastPos+1);
                            return divideByNegative($answerNoMinus);
                        } else if($op == "-"){
                            $answerNoMinus = str_replace("/-","/",$answer);
                            $answerNoMinus = substr($answerNoMinus,0,$lastPos).'+'.substr($answerNoMinus,$lastPos+1);
                            return divideByNegative($answerNoMinus);
                        } else if($op == "*"){
                            $answerNoMinus = str_replace("/-","/",$answer);
                            $answerNoMinus = substr($answerNoMinus,0,$lastPos).'*-'.substr($answerNoMinus,$lastPos+1);
                            return divideByNegative($answerNoMinus);
                        } else {
                            $answerNoMinus = str_replace("/-","/",$answer);
                            $answerNoMinus = '-'.substr($answerNoMinus,0);
                            return divideByNegative($answerNoMinus);
                        }
                    } else {
                        return $answer;
                    }
                }

                
                $parser = new ComplexMathParser();
                $evaluatorSubmitted = new ComplexEvaluator();
                $evaluatorCorrect = new ComplexEvaluator();
                $evalMathSubmittedAnswer = '';
                $evalMathCorrectAnswer = '';
                //Convert latex format into EvalMath format
                
                
                $compare = true;
                //I could make this array contain real numbers like 1.95,3.65,2.125?? Maybe this could avoid the divide by zero problem
                $iterants = 4;
                $decimalPointAccuracy = 13;
                $epsilon = 0.000000001;
                $iterations = array();
                for($i = 0; $i < $iterants; $i++){
                    // random real numbers [1.01,1.99]
                    $iterations[] = random_int(101,199)/100;
                }


                for($i = 0; $i < count($correctAnswers); $i++) {
                    echo '<div class = "answersummary">';
                    $counter = 0;
                    $answerNotReal = false;
                    $evalMathSubmittedAnswer = $submittedAnswers[$i];
                    $evalMathCorrectAnswer = $correctAnswers[$i];
                    
                    $evalMathSubmittedAnswer = str_replace("\\cdot","*", $evalMathSubmittedAnswer);
                    $evalMathSubmittedAnswer = str_replace("\\left(","(", $evalMathSubmittedAnswer);
                    $evalMathSubmittedAnswer = str_replace("\\right)",")", $evalMathSubmittedAnswer);
                    $evalMathSubmittedAnswer = str_replace("}{",")/(", $evalMathSubmittedAnswer);
                    $evalMathSubmittedAnswer = str_replace("\\frac{","(", $evalMathSubmittedAnswer);
                    $evalMathSubmittedAnswer = str_replace("}",")", $evalMathSubmittedAnswer);
                    $evalMathSubmittedAnswer = str_replace("^{","^(", $evalMathSubmittedAnswer);
                    $evalMathSubmittedAnswer = str_replace("\\pi","pi", $evalMathSubmittedAnswer);
                    $evalMathSubmittedAnswer = str_replace("\\sqrt{","sqrt(", $evalMathSubmittedAnswer);
                    $evalMathSubmittedAnswer = str_replace("\\exp","exp", $evalMathSubmittedAnswer);
                    $evalMathSubmittedAnswer = str_replace("\\sin","sin", $evalMathSubmittedAnswer);
                    $evalMathSubmittedAnswer = str_replace("\\cos","cos", $evalMathSubmittedAnswer);
                    $evalMathSubmittedAnswer = str_replace("\\tan","tan", $evalMathSubmittedAnswer);
                    $evalMathSubmittedAnswer = divideByNegative($evalMathSubmittedAnswer);
                    $evalMathSubmittedAnswer = str_replace("+-","-", $evalMathSubmittedAnswer);

                    $evalMathCorrectAnswer = str_replace("\\cdot","*", $evalMathCorrectAnswer);
                    $evalMathCorrectAnswer = str_replace("\\left(","(", $evalMathCorrectAnswer);
                    $evalMathCorrectAnswer = str_replace("\\right)",")", $evalMathCorrectAnswer);
                    $evalMathCorrectAnswer = str_replace("}{","/", $evalMathCorrectAnswer);
                    $evalMathCorrectAnswer = str_replace("\\frac{","(", $evalMathCorrectAnswer);
                    $evalMathCorrectAnswer = str_replace("}",")", $evalMathCorrectAnswer);
                    $evalMathCorrectAnswer = str_replace("\\pi","pi", $evalMathCorrectAnswer);
                    $evalMathCorrectAnswer = str_replace("\\sqrt{","sqrt(", $evalMathCorrectAnswer);
                    $evalMathCorrectAnswer = str_replace("^{","^(", $evalMathCorrectAnswer);

                    echo "<br>";
                    echo '<div class="answersummarycontent">';
                    echo "<span class = 'questionnum'>";
                    echo 'Q'.($i+1).'  ';
                    echo "</span>";
                    echo "<div id = 'qdisplay".$i."'>";
                    echo "</div>";
                    //Answer has been left blank
                    if($submittedAnswers[$i]==''){
                        echo "<br>";
                        echo "You have left this question blank";
                        echo "<br>";
                        echo "<br>";
                    //Answer has is an inequality relation
                    } else if((strpos($evalMathCorrectAnswer, '<')||strpos($evalMathCorrectAnswer, '>'))&&!strpos($evalMathCorrectAnswer,",")){
                        if((!strpos($evalMathSubmittedAnswer, '<')||!strpos($evalMathSubmittedAnswer, '>'))){
                            echo "<br>";
                            echo "This expression needs to be written as an inequation.";
                            echo "<br>";
                            echo "<br>";
                            $compare = false;
                            //echo 'SubmittedAnswer needs =';
                        } else {
                            if(strpos($evalMathCorrectAnswer,'<')){
                                if(strpos($evalMathSubmittedAnswer,'<')){
                                    $explodedCorrectAnswer = explode('<',$evalMathCorrectAnswer);
                                    $explodedSubmittedAnswer = explode('<', $evalMathSubmittedAnswer); 

                                    $array1 = preg_match_all("/[a-zA-Z]/", $evalMathSubmittedAnswer, $matches1);
                                    $array2 = preg_match_all("/[a-zA-Z]/", $evalMathCorrectAnswer, $matches2);
                                    $submittedAnswerVariables = array_unique($matches1[0]);
                                    $correctAnswerVariables = array_unique($matches2[0]);
                                    sort($submittedAnswerVariables);
                                    sort($correctAnswerVariables);

                                    $variablesArray = array_unique(array_merge($matches1[0],$matches2[0]));
                                    sort($variablesArray);

                                    try {
                            
                                        for($j = 0; $j < count($iterations); $j++){
                                            $submittedAnswerMap = array();
                                            $correctAnswerMap = array();
                                    
                                            $correctAnswer = $parser->parse($evalMathCorrectAnswer);
                                            $submittedAnswer = $parser->parse($evalMathSubmittedAnswer);
                                    
                                            for($k=0;$k<count($submittedAnswerVariables);$k++){
                                                $submittedAnswerMap[$submittedAnswerVariables[$k]] = $iterations[($j+$k)%count($iterations)];
                                            }
                                    
                                            $evaluatorSubmitted->setVariables($submittedAnswerMap);

                                            for($k=0;$k<count($correctAnswerVariables);$k++){
                                                $correctAnswerMap[$correctAnswerVariables[$k]] = $iterations[($j+$k)%count($iterations)];
                                            }

                                            $evaluatorCorrect->setVariables($correctAnswerMap);
                                            
                                            $correctAnswerValue = $correctAnswer->accept($evaluatorCorrect);
                                            $submittedAnswerValue = $submittedAnswer->accept($evaluatorSubmitted);

                                            //Make sure they are always complex for the algorithm to work!
                                            if(is_numeric($correctAnswerValue)){
                                                $correctAnswerValue = new Complex($correctAnswerValue,0);
                                            }

                                            if(is_numeric($submittedAnswerValue)){
                                                $submittedAnswerValue = new Complex($submittedAnswerValue,0);
                                            }
                        
                                            if(abs(round($correctAnswerValue->r(),$decimalPointAccuracy)-round($submittedAnswerValue->r(),$decimalPointAccuracy))>$epsilon || abs(round($correctAnswerValue->i(),$decimalPointAccuracy)-round($submittedAnswerValue->i(),$decimalPointAccuracy))>$epsilon){
                                                if($correctAnswerValue->i()==0 && $submittedAnswerValue->i()!=0){
                                                    $answerNotReal = true;
                                                }
                                                $compare = false;
                                            }
                                        }
                                    } catch (Exception $e){
                                        $compare = false;
                                        echo '<br>';
                                        echo 'Caught ya you blighter! Caught exception: ', $e->getMessage();
                                    }







                                } else if(strpos($evalMathSubmittedAnswer,'>')){
                                    $explodedCorrectAnswer = explode('<',$evalMathCorrectAnswer);
                                    $explodedSubmittedAnswer = explode('>', $evalMathSubmittedAnswer); 
                                }
                            } else if(strpos($evalMathCorrectAnswer,'>')){
                                if(strpos($evalMathSubmittedAnswer,'>')){
                                    $explodedCorrectAnswer = explode('>',$evalMathCorrectAnswer);
                                    $explodedSubmittedAnswer = explode('>', $evalMathSubmittedAnswer);
                                } else if(strpos($evalMathSubmittedAnswer,'<')){
                                    $explodedCorrectAnswer = explode('>',$evalMathCorrectAnswer);
                                    $explodedSubmittedAnswer = explode('<', $evalMathSubmittedAnswer);
                                }
                            }
                        }
                    //Answer has an '=' in it
                    } else if(strpos($evalMathCorrectAnswer, '=')&&!strpos($evalMathCorrectAnswer,",")){ 
                        //The submitted answer isn't written in the form of an equation
                        if(!strpos($evalMathSubmittedAnswer, '=')){
                            echo "<br>";
                            echo "This expression needs to be written as an equation.";
                            echo "<br>";
                            echo "<br>";
                            $compare = false;
                            //echo 'SubmittedAnswer needs =';
                        //The submitted answer is written in the form of an equation
                        } else {
                            //The subjects of the correct and submitted equations are not the same
                            if(substr($evalMathSubmittedAnswer,0,1)!=substr($evalMathCorrectAnswer,0,1)){
                                $compare = false;
                                echo 'SubmittedAnswers and Correct answers subject not the same';
                            //The subjects of the correct and submitted equations are the same
                            } else {
                                echo 'Subjects of the equations are the same';
                                $evalMathSubmittedAnswer = substr($evalMathSubmittedAnswer, strpos($evalMathSubmittedAnswer,'=')+1);
                                $evalMathCorrectAnswer = substr($evalMathCorrectAnswer, strpos($evalMathCorrectAnswer,'=')+1);

                                $array1 = preg_match_all("/[a-zA-Z]/", $evalMathSubmittedAnswer, $matches1);
                                $array2 = preg_match_all("/[a-zA-Z]/", $evalMathCorrectAnswer, $matches2);
                                $submittedAnswerVariables = array_unique($matches1[0]);
                                $correctAnswerVariables = array_unique($matches2[0]);
                                sort($submittedAnswerVariables);
                                sort($correctAnswerVariables);

                                $variablesArray = array_unique(array_merge($matches1[0],$matches2[0]));
                                sort($variablesArray);

                                try {
                        
                                    for($j = 0; $j < count($iterations); $j++){
                                        $submittedAnswerMap = array();
                                        $correctAnswerMap = array();
                                
                                        $correctAnswer = $parser->parse($evalMathCorrectAnswer);
                                        $submittedAnswer = $parser->parse($evalMathSubmittedAnswer);
                                
                                        for($k=0;$k<count($submittedAnswerVariables);$k++){
                                            $submittedAnswerMap[$submittedAnswerVariables[$k]] = $iterations[($j+$k)%count($iterations)];
                                        }
                                
                                        $evaluatorSubmitted->setVariables($submittedAnswerMap);

                                        for($k=0;$k<count($correctAnswerVariables);$k++){
                                            $correctAnswerMap[$correctAnswerVariables[$k]] = $iterations[($j+$k)%count($iterations)];
                                        }

                                        $evaluatorCorrect->setVariables($correctAnswerMap);
                                        
                                        $correctAnswerValue = $correctAnswer->accept($evaluatorCorrect);
                                        $submittedAnswerValue = $submittedAnswer->accept($evaluatorSubmitted);

                                        //Make sure they are always complex for the algorithm to work!
                                        if(is_numeric($correctAnswerValue)){
                                            $correctAnswerValue = new Complex($correctAnswerValue,0);
                                        }

                                        if(is_numeric($submittedAnswerValue)){
                                            $submittedAnswerValue = new Complex($submittedAnswerValue,0);
                                        }
                    
                                        if(abs(round($correctAnswerValue->r(),$decimalPointAccuracy)-round($submittedAnswerValue->r(),$decimalPointAccuracy))>$epsilon || abs(round($correctAnswerValue->i(),$decimalPointAccuracy)-round($submittedAnswerValue->i(),$decimalPointAccuracy))>$epsilon){
                                            if($correctAnswerValue->i()==0 && $submittedAnswerValue->i()!=0){
                                                $answerNotReal = true;
                                            }
                                            $compare = false;
                                        }
                                    }
                                } catch (Exception $e){
                                    $compare = false;
                                    echo '<br>';
                                    echo 'Caught ya you blighter! Caught exception: ', $e->getMessage();
                                }
                            }
                            if($compare){
                                $score++;
                                echo "<br>";
                                echo "Your answer ";
                                echo "<span id = 'sadisplay".$i."'>";
                                echo "</span>";
                                echo " is Correct.";
                                echo "<br>";
                                if($submittedAnswers[$i]!=$correctAnswers[$i]){
                                    echo "Your answer doesn't match the suggested correct answer for some reason.";
                                    echo "<br>";
                                    echo "This is the suggested correct answer: ".$correctAnswers[$i];
                                    echo "<br>";
                                }
                                echo "<br>";
                            } else {
                                if($answerNotReal){
                                    echo "<br>";
                                    echo "Your answer ";
                                    echo "<div id = 'sadisplay".$i."'>";
                                    echo "</div>";
                                    echo " should not contain a complex number <br> The correct answer is: ";
                                    echo "<div id = 'cadisplay".$i."'>";
                                    echo "</div>";
                                    echo "<br>";
                                    echo "<br>";
                                } else {
                                    echo "<br>";
                                    echo "Your answer ";
                                    echo "<div id = 'sadisplay".$i."'>";
                                    echo "</div>";
                                    echo " is Incorrect <br> The correct answer is: ";
                                    echo "<div id = 'cadisplay".$i."'>";
                                    echo "</div>";
                                    echo "<br>";
                                    echo "<br>";
                                }
                            }
                            if($markedByTutor){
                                echo "Your logical reasoning points for this question is: ";
                                echo $logicalReasoningPoints[$i];
                            }
                            $compare = true;
                        }
                    //Answer is a mathematical expression
                    } else if (!strpos($evalMathCorrectAnswer, '=')&&!strpos($evalMathCorrectAnswer,",")){
                        //echo 'Mathematical Expression';
                        $array1 = preg_match_all("/[a-zA-Z]/", $evalMathSubmittedAnswer, $matches1);
                        $array2 = preg_match_all("/[a-zA-Z]/", $evalMathCorrectAnswer, $matches2);
                        $submittedAnswerVariables = array_unique($matches1[0]);
                        $correctAnswerVariables = array_unique($matches2[0]);
                        sort($submittedAnswerVariables);
                        sort($correctAnswerVariables);

                        $variablesArray = array_unique(array_merge($matches1[0],$matches2[0]));
                        sort($variablesArray);
                        
                        try {
                            for($j = 0; $j < count($iterations); $j++){
                                $submittedAnswerMap = array();
                                $correctAnswerMap = array();
                                
                                $correctAnswer = $parser->parse($evalMathCorrectAnswer);
                                $submittedAnswer = $parser->parse($evalMathSubmittedAnswer);
                                
                                for($k=0;$k<count($submittedAnswerVariables);$k++){
                                    $submittedAnswerMap[strval($submittedAnswerVariables[$k])] = $iterations[($j+$k)%count($iterations)];
                                }
                                
                                $evaluatorSubmitted->setVariables($submittedAnswerMap);

                                for($k=0;$k<count($correctAnswerVariables);$k++){
                                    $correctAnswerMap[strval($correctAnswerVariables[$k])] = $iterations[($j+$k)%count($iterations)];
                                }

                                $evaluatorCorrect->setVariables($correctAnswerMap);


                                $correctAnswerValue = $correctAnswer->accept($evaluatorCorrect);
                                $submittedAnswerValue = $submittedAnswer->accept($evaluatorSubmitted);

                                //Make sure they are always complex for the algorithm to work!
                                if(is_numeric($correctAnswerValue)){
                                    $correctAnswerValue = new Complex($correctAnswerValue,0);
                                }

                                if(is_numeric($submittedAnswerValue)){
                                    $submittedAnswerValue = new Complex($submittedAnswerValue,0);
                                }

                                
                                
                                if(abs(round($correctAnswerValue->r(),$decimalPointAccuracy)-round($submittedAnswerValue->r(),$decimalPointAccuracy))>$epsilon || abs(round($correctAnswerValue->i(),$decimalPointAccuracy)-round($submittedAnswerValue->i(),$decimalPointAccuracy))>$epsilon){
                                    if($correctAnswerValue->i()==0 && $submittedAnswerValue->i()!=0){
                                        $answerNotReal = true;
                                    }
                                    $compare = false;
                                    //echo $correctAnswerValue->r().'__wrong__'.$submittedAnswerValue->r();
                                } else {
                                    //echo $correctAnswerValue->r().'_right__'.$submittedAnswerValue->r();
                                }
                            }
                        } catch (Exception $e){
                            $compare = false;
                            echo '<br>';
                            echo 'Caught ya you blighter! Caught exception: ', $e->getMessage();
                        }
    
                        if($compare){
                            $score++;
                            echo "<br>";
                            echo "Your answer ";
                            echo "<span id = 'sadisplay".$i."'>";
                            echo "</span>";
                            echo " is Correct.";
                            echo "<br>";
                            if($submittedAnswers[$i]!=$correctAnswers[$i]){
                                echo "Your answer doesn't match the suggested correct answer for some reason.";
                                echo "<br>";
                                echo "This is the suggested correct answer: ".$correctAnswers[$i];
                                echo "<br>";
                            }
                            echo "<br>";
                        } else {
                            if($answerNotReal){
                                echo "<br>";
                                echo "Your answer ";
                                echo "<div id = 'sadisplay".$i."'>";
                                echo "</div>";
                                echo " should not contain a complex number <br> The correct answer is: ";
                                echo "<div id = 'cadisplay".$i."'>";
                                echo "</div>";
                                echo "<br>";
                                echo "<br>";
                            } else {
                                echo "<br>";
                                echo "Your answer ";
                                echo "<div id = 'sadisplay".$i."'>";
                                echo "</div>";
                                echo " is Incorrect <br> The correct answer is: ";
                                echo "<div id = 'cadisplay".$i."'>";
                                echo "</div>";
                                echo "<br>";
                                echo "<br>";
                            }
                        }
                        if($markedByTutor){
                            echo "Your logical reasoning points for this question is: ";
                            echo $logicalReasoningPoints[$i];
                        }
                        $compare = true;
                    //Answer is an array of multiple expressions
                    } else if(!strpos($evalMathCorrectAnswer, '=')&&strpos($evalMathCorrectAnswer,",")){
                        echo 'Multiple Expressions';
                        // I will have to go through each element first and then check if it has an equation symbol or not
                        //array containing indicies visited in submitted answers for each correct answer
                        $explodedSubmittedAnswers = explode(",",$evalMathSubmittedAnswer);
                        // e.g. ['2','9a+b','a+b']
                        $explodedCorrectAnswers = explode(",",$evalMathCorrectAnswer);
                        // e.g. ['3','9a+b+1','a+b']
                        
                        $found = false;
                        $counter = 0;
                        foreach($explodedCorrectAnswers as $explodedCorrectAnswer){
                            $correctAnswerSelection = $explodedCorrectAnswer;
                            foreach($explodedSubmittedAnswers as $explodedSubmittedAnswer){
                                $submittedAnswerSelection = $explodedSubmittedAnswer;
                                $array1 = preg_match_all("/[a-zA-Z]/", $explodedSubmittedAnswer, $matches1);
                                $array2 = preg_match_all("/[a-zA-Z]/", $explodedCorrectAnswer, $matches2);
                                $submittedAnswerVariables = array_unique($matches1[0]);
                                $correctAnswerVariables = array_unique($matches2[0]);
                                sort($submittedAnswerVariables);
                                sort($correctAnswerVariables);

                                $variablesArray = array_unique(array_merge($matches1[0],$matches2[0]));
                                sort($variablesArray);

                                try {
                                    for($j = 0; $j < count($iterations); $j++){
                                        $submittedAnswerMap = array();
                                        $correctAnswerMap = array();
                                            
                                        $correctAnswer = $parser->parse($explodedCorrectAnswer);
                                        $submittedAnswer = $parser->parse($explodedSubmittedAnswer);
                                            
                                        for($k=0;$k<count($submittedAnswerVariables);$k++){
                                            $submittedAnswerMap[$submittedAnswerVariables[$k]] = $iterations[($j+$k)%count($iterations)];
                                        }
                                            
                                        $evaluatorSubmitted->setVariables($submittedAnswerMap);
                
                                        for($k=0;$k<count($correctAnswerVariables);$k++){
                                            $correctAnswerMap[$correctAnswerVariables[$k]] = $iterations[($j+$k)%count($iterations)];
                                        }
                
                                        $evaluatorCorrect->setVariables($correctAnswerMap);
                                        $correctAnswerValue = $correctAnswer->accept($evaluatorCorrect);
                                        $submittedAnswerValue = $submittedAnswer->accept($evaluatorSubmitted);

                                        //Make sure they are always complex for the algorithm to work!
                                        if(is_numeric($correctAnswerValue)){
                                            $correctAnswerValue = new Complex($correctAnswerValue,0);
                                        }

                                        if(is_numeric($submittedAnswerValue)){
                                            $submittedAnswerValue = new Complex($submittedAnswerValue,0);
                                        }
                                
                                        if(abs(round($correctAnswerValue->r(),$decimalPointAccuracy)-round($submittedAnswerValue->r(),$decimalPointAccuracy))<$epsilon && abs(round($correctAnswerValue->i(),$decimalPointAccuracy)-round($submittedAnswerValue->i(),$decimalPointAccuracy))<$epsilon){
                                            $found = true;
                                        } else {
                                            $found = false;
                                            break;
                                        }
                
                                    }
                                } catch (Exception $e){
                                    $compare = false;
                                    echo '<br>';
                                    echo 'Caught ya you blighter! Caught exception: ', $e->getMessage();
                                }

                                if($found){
                                    $counter++;
                                    $found = false;
                                    break;
                                }
                            }
                        }

                        if($counter!=count($explodedCorrectAnswers)){
                            $compare = false;
                        }
                        //echo 'Counter '.$counter;
                        //echo 'Correct Answers '.count($explodedCorrectAnswers);
    
                        if($compare){
                            $score++;
                            echo "<br>";
                            echo "Your answer ";
                            echo "<span id = 'sadisplay".$i."'>";
                            echo "</span>";
                            echo " is Correct.";
                            echo "<br>";
                            if($submittedAnswers[$i]!=$correctAnswers[$i]){
                                echo "Your answer doesn't match the suggested correct answer for some reason.";
                                echo "<br>";
                                echo "This is the suggested correct answer: ".$correctAnswers[$i];
                                echo "<br>";
                            }
                            echo "<br>";
                        } else {
                            if($answerNotReal){
                                echo "<br>";
                                echo "Your answer ";
                                echo "<div id = 'sadisplay".$i."'>";
                                echo "</div>";
                                echo " should not contain a complex number <br> The correct answer is: ";
                                echo "<div id = 'cadisplay".$i."'>";
                                echo "</div>";
                                echo "<br>";
                                echo "<br>";
                            } else {
                                echo "<br>";
                                echo "Your answer ";
                                echo "<div id = 'sadisplay".$i."'>";
                                echo "</div>";
                                echo " is Incorrect <br> The correct answer is: ";
                                echo "<div id = 'cadisplay".$i."'>";
                                echo "</div>";
                                echo "<br>";
                                echo "<br>";
                            }
                        }
                        if($markedByTutor){
                            echo "Your logical reasoning points for this question is: ";
                            echo $logicalReasoningPoints[$i];
                        }
                        $compare = true;
                    //Answer is an array of multiple equations
                    } else if(strpos($evalMathCorrectAnswer, '=')&&strpos($evalMathCorrectAnswer,",")){
                        echo 'Multiple equations';
                        // I will have to go through each element first and then check if it has an equation symbol or not
                        //array containing indicies visited in submitted answers for each correct answer
                        $explodedSubmittedAnswers = explode(",",$evalMathSubmittedAnswer);
                        // e.g. ['y=2','9a+b','a+b']
                        $explodedCorrectAnswers = explode(",",$evalMathCorrectAnswer);
                        // e.g. ['3','9a+b+1','a+b']
                        
                        $found = false;
                        $counter = 0;
                        try {
                            foreach($explodedCorrectAnswers as $explodedCorrectAnswer){
                                $correctAnswerSelection = $explodedCorrectAnswer;
                                foreach($explodedSubmittedAnswers as $explodedSubmittedAnswer){
                                    $submittedAnswerSelection = $explodedSubmittedAnswer;

                                    $submittedAnswerSelectionNoEqual = substr($submittedAnswerSelection, strpos($submittedAnswerSelection,'=')+1);
                                    $correctAnswerSelectionNoEqual = substr($correctAnswerSelection, strpos($correctAnswerSelection,'=')+1);

                                    $array1 = preg_match_all("/[a-zA-Z]/", $explodedSubmittedAnswer, $matches1);
                                    $array2 = preg_match_all("/[a-zA-Z]/", $explodedCorrectAnswer, $matches2);
                                    $submittedAnswerVariables = array_unique($matches1[0]);
                                    $correctAnswerVariables = array_unique($matches2[0]);
                                    sort($submittedAnswerVariables);
                                    sort($correctAnswerVariables);

                                    $variablesArray = array_unique(array_merge($matches1[0],$matches2[0]));
                                    sort($variablesArray);

                                    for($j = 0; $j < count($iterations); $j++){
                                        $submittedAnswerMap = array();
                                        $correctAnswerMap = array();
                                            
                                        $correctAnswer = $parser->parse($explodedCorrectAnswer);
                                        $submittedAnswer = $parser->parse($explodedSubmittedAnswer);
                                            
                                        for($k=0;$k<count($submittedAnswerVariables);$k++){
                                            $submittedAnswerMap[$submittedAnswerVariables[$k]] = $iterations[($j+$k)%count($iterations)];
                                        }
                                            
                                        $evaluatorSubmitted->setVariables($submittedAnswerMap);
                
                                        for($k=0;$k<count($correctAnswerVariables);$k++){
                                            $correctAnswerMap[$correctAnswerVariables[$k]] = $iterations[($j+$k)%count($iterations)];
                                        }
                
                                        $evaluatorCorrect->setVariables($correctAnswerMap);
                                        $correctAnswerValue = $correctAnswer->accept($evaluatorCorrect);
                                        $submittedAnswerValue = $submittedAnswer->accept($evaluatorSubmitted);

                                        //Make sure they are always complex for the algorithm to work!
                                        if(is_numeric($correctAnswerValue)){
                                            $correctAnswerValue = new Complex($correctAnswerValue,0);
                                        }

                                        if(is_numeric($submittedAnswerValue)){
                                            $submittedAnswerValue = new Complex($submittedAnswerValue,0);
                                        }
                                
                                        if(abs(round($correctAnswerValue->r(),$decimalPointAccuracy)-round($submittedAnswerValue->r(),$decimalPointAccuracy))<$epsilon && abs(round($correctAnswerValue->i(),$decimalPointAccuracy)-round($submittedAnswerValue->i(),$decimalPointAccuracy))<$epsilon){
                                            $found = true;
                                            if(substr($correctAnswerSelection,0,1)!=substr($submittedAnswerSelection,0,1)){
                                                $found = false;
                                            }
                                        } else {
                                            $found = false;
                                            break;
                                        }
                
                                    }
                                    if($found){
                                        $counter++;
                                        $found = false;
                                        break;
                                    }
                                }
                            }
                        } catch (Exception $e){
                            $compare = false;
                            echo '<br>';
                            echo 'Caught ya you blighter! Caught exception: ', $e->getMessage();
                        }

                        if($counter!=count($explodedCorrectAnswers)){
                            //echo $counter;
                            //echo count($explodedCorrectAnswers);
                            $compare = false;
                        }
                        echo 'Counter '.$counter;
                        echo 'Correct Answers '.count($explodedCorrectAnswers);
    
                        if($compare){
                            $score++;
                            echo "<br>";
                            echo "Your answer ";
                            echo "<span id = 'sadisplay".$i."'>";
                            echo "</span>";
                            echo " is Correct.";
                            echo "<br>";
                            if($submittedAnswers[$i]!=$correctAnswers[$i]){
                                echo "Your answer doesn't match the suggested correct answer for some reason.";
                                echo "<br>";
                                echo "This is the suggested correct answer: ".$correctAnswers[$i];
                                echo "<br>";
                            }
                            echo "<br>";
                        } else {
                            if($answerNotReal){
                                echo "<br>";
                                echo "Your answer ";
                                echo "<div id = 'sadisplay".$i."'>";
                                echo "</div>";
                                echo " should not contain a complex number <br> The correct answer is: ";
                                echo "<div id = 'cadisplay".$i."'>";
                                echo "</div>";
                                echo "<br>";
                                echo "<br>";
                            } else {
                                echo "<br>";
                                echo "Your answer ";
                                echo "<div id = 'sadisplay".$i."'>";
                                echo "</div>";
                                echo " is Incorrect <br> The correct answer is: ";
                                echo "<div id = 'cadisplay".$i."'>";
                                echo "</div>";
                                echo "<br>";
                                echo "<br>";
                            }
                        }
                        if($markedByTutor){
                            echo "Your logical reasoning points for this question is: ";
                            echo $logicalReasoningPoints[$i];
                        }
                        $compare = true;
                        //the answer is just a number that needs to be checked against another number
                    }

                    echo "<script>";
                    echo "var questionFieldSpan".$i." = document.getElementById('qdisplay".$i."');";
                    echo "var correctAnswerFieldSpan".$i." = document.getElementById('cadisplay".$i."');";
                    echo "var submittedAnswerFieldSpan".$i." = document.getElementById('sadisplay".$i."');";

                    echo "var MQ".$i." = MathQuill.getInterface(2);";
                    echo "var MQca".$i." = MathQuill.getInterface(2);";
                    echo "var MQsa".$i." = MathQuill.getInterface(2);";

                    echo "var questionField".$i." = MQ".$i.".StaticMath(questionFieldSpan".$i.");";
                    echo "var correctAnswerField".$i." = MQca".$i.".StaticMath(correctAnswerFieldSpan".$i.");";
                    echo "var submittedAnswerField".$i." = MQsa".$i.".StaticMath(submittedAnswerFieldSpan".$i.");";
                    
                    echo "questionField".$i.".latex(questions[".$i."]);";
                    echo "if(correctAnswerField".$i."!=null) {";
                    echo "  correctAnswerField".$i.".latex(correctAnswers[".$i."]);";
                    echo "}";
                    echo "if(submittedAnswerField".$i."!=null) {";
                    echo "  submittedAnswerField".$i.".latex(submittedAnswers[".$i."]);";
                    echo "}";
                    echo "</script>";
                    echo '</div>';
                    echo '</div>';
                }
            
                echo "<br>";
                echo "<br>";
                echo 'You scored ';
                echo $score;
                echo ' out of ';
                echo count($correctAnswers);

                $totalLogicalPoints = 0;
                if($markedByTutor){
                    foreach($logicalReasoningPoints as $points){
                        $totalLogicalPoints += $points;
                        echo '<br>';
                        echo $points;
                    }
                    echo "<br>";
                    echo "<br>";
                    echo 'Your logical point score is ';
                    echo $totalLogicalPoints;
                }

                $bronzeLimit = 50;
                $silverLimit = 25;
                
                $bronzePAdd = intdiv($score,2) + intdiv($totalLogicalPoints,2);  //have averages so put in number of questions in place of 2

                $bronzeP += $bronzePAdd;

                if($bronzeP > $bronzeLimit) {
                    $silverPAdd = intdiv($bronzeP,$bronzeLimit);
                    $silverP += $silverPAdd;
                    $bronzeP -= $bronzeLimit*$silverPAdd;
                }

                if($silverP > $silverLimit) {
                    $goldPAdd = intdiv($silverP,$silverLimit);
                    $goldP += $goldPAdd;
                    $silverP -= $silverLimit*$silverPAdd;
                }

                echo "<br><br>";
                echo 'You have earned '.$bronzePAdd. ' bronze points!';
                echo "<br><br>";
                echo 'Your new points are: <br>';
                echo 'Bronze: '.$bronzeP.'<br>';
                echo 'Silver: '.$silverP.'<br>';
                echo 'Gold: '.$goldP.'<br>';

            ?>
        <a href='home.php'>
            <button>
            Return to Home
            </button>
        </a>
        </div>
        </div>
    </body>
</html>


<?php

$sql = "UPDATE users SET bronzePoints = ?, silverPoints = ?, goldPoints = ? WHERE idUsers = ?;";
if(!mysqli_stmt_prepare($stmt, $sql)){
    header("Location: testsummary.php?error=sqlerror");
    exit();
} 
mysqli_stmt_bind_param($stmt, "iiii", $bronzeP, $silverP, $goldP, $userId);
mysqli_stmt_execute($stmt);
    
//close connection
mysqli_stmt_close($stmt);
mysqli_close($conn);

//print_r($_SESSION);

?>