<?php
    require_once('includes/Question.class.php');
    //Develop a code system that is more clear for the switch cases
    
    //total number of questions asked in the test
    $num_questions = 5;  
    $questionBlurbs = [];
    $questions = [];
    $answers = [];
    $submittedanswers = [];
    $imagereferences = [];
    $submittedWorkings = [];
    $logicalReasoningPoints = [];
    $mustHaveSymbols = [];
    $mustNOTHaveSymbols = [];

    $bytes = random_bytes(5);
    $testid = bin2hex($bytes);

    date_default_timezone_set('Pacific/Auckland');
    $time = time(); 

    if($createdByTutor){
        require_once $newtest.'.class.php';
    } else {
        require_once 'includes/'.$newtest.'.class.php';
    }
    
    //while(strpos($newtest,'/')){
    //    $newtest = substr($newtest, strpos($newtest,'/')+1);
    //}

    file_get_contents('');

    $explodedNewTest = explode('/',$newtest);
    //echo 'No way!';
    //print_r($explodedNewTest);
    $year = $explodedNewTest[1];
    $subject = $explodedNewTest[2];
    $test = $explodedNewTest[3];
    

    $question_objects = [];


    switch($year){
        case "BASIC":
            switch($subject){
                case "Arithmetic":
                    switch($test){
                        case "Addition":
                            for($i=0; $i<$num_questions; $i++){
                                array_push($question_objects, new AdditionQuestion(1,20));
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Subtraction":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new SubtractionQuestion(1,20));
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Multiplication":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new MultiplicationQuestion(1,12));
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Division":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new DivisionQuestion(1,12));
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Highest_Common_Factor":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new HighestCommonFactorQuestion());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Lowest_Common_Multiple":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new LowestCommonMultipleQuestion());
                            }
                            $type = $testCodeNames[$test];
                            break;
                    }
                    break;
                case "Conversions":
                    switch($test){
                        case "Time_Conversion":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new TimeConversionQuestion());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Length_Conversion":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new LengthConversionQuestion());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Area_Conversion":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new AreaConversionQuestion());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Volume_Conversion":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new VolumeConversionQuestion());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Speed_Conversion":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new SpeedConversionQuestion());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Mass_Conversion":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new MassConversionQuestion());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Currency_Conversion":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new CurrencyConversionQuestion());
                            }
                            $type = $testCodeNames[$test];
                            break;
                    }
                    break;
                case "Logical_Reasoning":
                    break;
                case "Sets":
                    break;
                case "Functions":
                    break;
                case "Natural_Numbers":
                    switch($test){
                        case "Identify_Natural_Numbers":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new IdentifyNaturalNumbers());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Ordering_Numbers":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new OrderingNumbersQuestion());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Multiplicative_Distribution":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new MultiplicationDistributionQuestion());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Combinations":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new Combinations());
                            }
                            $type = $testCodeNames[$test];
                            break;
                    }
                    break;
                case "Integer_Numbers":
                    switch($test){
                        case "Additive_Inverses":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new AdditionInverseQuestion());
                            }
                            $type = $testCodeNames[$test];
                            break;
                    }
                    break;
                case "Rational_Numbers":
                    switch($test){
                        case "Multiplicative_Inverses":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new MultiplicationInverseQuestion());
                            }
                            $type = $testCodeNames[$test];
                            break;
                    }
                    break;
                case "Real_Numbers":
                    break;
            }
            break;
        case "YR9":
            switch($subject){
                case "Number":
                    break;
                case "Measurement":
                    break;
                case "Geometry":
                    break;
                case "Algebra":
                    break;
                case "Statistics":
                    break;
            }
            break;
        case "YR10":
            switch($subject){
                case "Number":
                    switch($test){
                        case "Fraction_Addition":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new FractionAdditionQuestion());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Fraction_Multiplication":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new FractionMultiplicationQuestion());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Fraction_Conversion":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new FractionConversionQuestion());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Percentage_Conversion":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new PercentageConversionQuestion());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Determine_Sequence":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new DetermineSequenceQuestion());
                            }
                            $type = $testCodeNames[$test];
                            break;
                    }
                    break;
                case "Measurement":
                    switch($test){
                        case "Basic_Area":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new BasicAreaQuestion());
                            }
                            $type = $testCodeNames[$test];
                            break;
                    }
                    break;
                case "Geometry":
                    break;
                case "Algebra":
                    break;
                case "Statistics":
                    break;
            }
            break;
        case "NCEALVL1":
            switch($subject){
                case "Algebra":
                    switch($test){
                        case "Algebra_Simple":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new AlgebraSimpleQuestion());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Expanding_Quadratics":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new ExpandingQuadraticsQuestion());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Factorising_Quadratics":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new FactorisingQuadraticsQuestion());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Simplifying_Exponents":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new SimplifyExponentQuestion());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Quadratic_Roots":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new QuadraticRoots());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Factorise_Roots":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new FactoriseRoots());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Perimeter_Solving":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new PerimeterSolving());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Find_Quadratic_Roots":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new FindQuadraticRoots());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Simultaneous_Equations":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new SimultaneousEquations());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Solving_Exponents":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new SolvingExponents());
                            }
                            $type = $testCodeNames[$test];
                            break;

                    }
                    break;
                case "TablesEquationsAndGraphs":
                    switch($test){
                        case "Graph_Equations":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new GraphEquations());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Table_Equations":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new TableEquations());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Number_Patterns":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new NumberPatterns());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Maxima_Minima":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new MaximaMinima());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Intercepts":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new Intercepts());
                            }
                            $type = $testCodeNames[$test];
                            break;
                    }
                    break;
                case "GeometricReasoning":
                    switch($test){
                        case "Straight_Lines":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new StraightLines());
                            }
                            $type = $testCodeNames[$test];
                            break;
                    }
                    break;
                case "ChanceAndData":
                    break;
                case "Numeracy":
                    break;
                case "LinearAlgebra":
                    break;
                case "Measurement":
                    break;
                case "RightAngledTriangles":
                    switch($test){
                        case "Pythagoras_Theorem":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new PythagorasQuestion());
                            }
                            $type = $testCodeNames[$test];
                            break;

                    }
                    break;
                case "GeometricRepresentations":
                    break;
                case "TransformationGeometry":
                    break;
                case "Chance":
                    break;
            }
            break;
        case "NCEALVL2":
            switch($subject){
                case "Algebra":
                    switch($test){
                        case "Simplifying_Expressions":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new SimplifyExpressions());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Quadratic_Linear_Unknown":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new QuadraticLinearUnknown());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Quadratic_One_Solution":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new QuadraticOneSolution());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Quadratics_Roots_Whole":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new QuadraticWholeRoots());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Quadratic_Algebraic_Solutions":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new QuadraticAlgebraicSolutions());
                            }
                            $type = $testCodeNames[$test];
                            break;
                    }
                    break;
                case "Calculus":
                    switch($test){
                        case "Polynomial_Differentiation":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new DifferentiationPolynomialsQuestion());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Polynomial_Integration":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new IntegrationPolynomialsQuestion());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Distance_Speed_Acceleration":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new DistanceSpeedAcceleration());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Tangent_Equations":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new TangentEquations());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Gradient_Intersection":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new GradientIntersection());
                            }
                            $type = $testCodeNames[$test];
                            break;

                    }
                    break;
                case "Probability":
                    switch($test){
                        case "Probability_Tables":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new ProbabilityTables());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Expectation":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new Expectation());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Continuous_Data":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new ContinuousData());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Normal_Distribution":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new NormalDistribution());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Probability_Trees":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new ProbabilityTrees());
                            }
                            $type = $testCodeNames[$test];
                            break;
                    }
                    break;
                case "Geometry":
                    break;
                case "Sequences":
                    break;
                case "Graphs":
                    break;
                case "Trigonometry":
                    switch($test){
                        case "Radian_Conversion":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new RadianConversion());
                            }
                            $type = $testCodeNames[$test];
                            break;

                    }
                    break;
                case "Networks":
                    break;
                case "Chance":
                    break;
                case "SystemsOfEquations":
                    break;
            }
            break;
        case "NCEALVL3":
            switch($subject){
                case "AlgebraOfComplexNumbers":
                    switch($test){
                        case "Complex_Arithmetic":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new ComplexArithmetic());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Complex_Roots":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new ComplexRoots());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Rectangular_Polar":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new RectangularPolar());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Complex_Conjugate":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new ComplexConjugate());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Demoivres_Theorem":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new DemoivresTheorem());
                            }
                            $type = $testCodeNames[$test];

                    }
                    break;
                case "Differentiation":
                    switch($test){
                        case "Differentiate_Expressions":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new DifferentiateExpressions());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Quadratic_Optimisation":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new QuadraticOptimisation());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Parametric_Equations":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new ParametricEquations());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Chain_Rule":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new ChainRule());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Gradient_Functions":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new GradientFunctions());
                            }
                            $type = $testCodeNames[$test];
                            break;
                    }
                    break;
                case "Integration":
                    switch($test){
                        case "Integrate_Expressions":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new IntegrateExpressions());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Integrate_to_Position":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new IntegratetoPosition());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Limit_Integration":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new LimitIntegration());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Separable_Differential_Equations":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new SeparableDifferentialEquations());
                            }
                            $type = $testCodeNames[$test];
                            break;
                        case "Trig_Integration":
                            for($i = 0; $i < $num_questions; $i++) {
                                array_push($question_objects, new TrigIntegration());
                            }
                            $type = $testCodeNames[$test];
                            break;
                    }
                    break;
                case "Probability_Concepts":
                    break;
                case "Probability_Distributions":
                    break;
                case "Conic_Sections":
                    break;
                case "Linear_Programming":
                    break;
                case "Trigonometric_Methods":
                    break;
                case "Critical_Path_Analysis":
                    break;
                case "Time_Series":
                    break;
                case "Systems_of_Simultaneous_Equations":
                    break;
            }
            break;
        case "SCHOL":
            break;
    }

    for($i = 0; $i < $num_questions; $i++){
        $question_object = $question_objects[$i]; 
        array_push($questionBlurbs, $question_object->getBlurb());
        array_push($answers, $question_object->getAnswer());
        array_push($questions, $question_object->getQuestion());
        array_push($submittedanswers, "");
        array_push($submittedWorkings, "");
        array_push($logicalReasoningPoints, 0);
        array_push($imagereferences, $question_object->generateImage($testid, $i));
    }

    foreach($question_objects as $question_object){
        unset($question_object);
    }

    $question_num = 0;
?>