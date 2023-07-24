<!-- There's a problem with the javascript referencing of div elements on the page-->

<?php
    session_start();

    require 'includes/testcodes.inc.php';
    $_SESSION['pageReload'] = true;
    
    if(isset($_SESSION['testID'])){
        unset($_SESSION['testID']);
    }

    if(isset($_SESSION['inputs'])){
        unset($_SESSION['inputs']);
    }

    if(isset($_SESSION['answers'])){
        unset($_SESSION['answers']);
    }

    if(isset($_SESSION['questions'])){
        unset($_SESSION['questions']);
    }

    if(isset($_SESSION['imagerefs'])){
        unset($_SESSION['imagerefs']);
    }

    if(isset($_SESSION['t'])){
        unset($_SESSION['t']);
    }

    if(isset($_SESSION['check'])){
        unset($_SESSION['check']);
    }

    if(isset($_SESSION['types'])){
        unset($_SESSION['types']);
    }
    
    //The header for all screens
    require 'Header/header.php';
    //This pulls all the savedtests table in the deltamaths database
    require 'includes/LoadTests/home_loadtests.inc.php'; 

    $button_ids;

    /**
     * Creates a list of buttons that will direct user to the test screen for new tests
     *
     * @param array $level Types Array
     * @param string $name Name of button
     * @param string $id ID for the button 
     */
    function createTestLevelBlocks($level, $name, $testlevel)
    {
        $output = '';
        $output .= '<form method ="post" action="quiz.php">';
        $output .= '<div class = "skill_buttons" id = "test_'.$testlevel.'" style="display: none">';
        $output .= '<div><button disabled id="'.$testlevel.'"class="active_header">'.$name.'</button></div>';

        foreach($level as $type){
            $modType = $type;
            $modType = str_replace("_"," ", $modType);
            $output .= '<div>';
            $output .=  '<button id = "'.$type.'" class="'.str_replace('/','_',$testlevel).'"type = "submit" name = "newtest" value="TestClasses/'.$testlevel.'/'.$type.'">';
            $output .= $modType;
            $output .= '</button>';
            $output .= '</div>';
        }
        $output .= '</div>';
        $output .= '</form>';
        echo $output;

    }

    /**
     * Creates a list of buttons that will direct user to the test screen for new tests
     *
     * @param array $level Types Array
     * @param string $name Name of button
     * @param string $id ID for the button 
     */
    function createExamLevelBlocks($level, $name, $testlevel)
    {
        $output = '';
        $output .= '<form method ="post" action="quiz.php">';
        $output .= '<div class = "test_buttons" id = "test_'.$testlevel.'">';
        $output .= '<div><a>'.$name.'</a></div>';

        foreach($level as $type){
            $modType = $type;
            $modType = str_replace("_"," ", $modType);
            $output .=  '<button id = "'.$type.'" type = "submit" name = "newexam" value="ExamClasses/'.$testlevel.'/'.$type.'">';
            $output .= $modType;
            $output .= '</button>';
            $output .= '<br>';
        }
        $output .= '</div>';
        $output .= '</form>';
        echo $output;

    }

    /**
     * Creates a list of buttons that will direct user to the test screen for saved tests
     *
     */
    function createSavedTests($types, $ids, $subs, $dates)
    {
        $output = '';
        $button_ids = $types;
        date_default_timezone_set('Pacific/Auckland');
        $date = new DateTime();
        $output .= '<form method ="post" action="quiz.php">';
        $output .= '<div class = "test_buttons">';
        for($i = 0; $i < count($ids); $i++) {
            $answered = 0;
            for($j = 0; $j < count($subs[$i]); $j++){
                if($subs[$i][$j]!=""){
                    $answered += 1;
                }
            }
            $percentage = $answered/count($subs[$i]);
            $date->setTimeStamp($dates[$i]);
            $output .= '<button type = "submit" name = "savedtest" value = "'.$ids[$i].'">'.$types[$i].' '.$date->format('d/m/y g:i A').
                    '    '.$percentage.'</button>';
            
        }
        if(count($ids) < 7){
            $count = count($ids);
            while($count < 7){
                $output .= '<button name = "blanksavedtest" disabled> -------- </button>';
                $count++;
            }
        }
        $output .= '</div>';
        $output .= '</form>';
        echo $output;

    }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>spritemaths</title>
        <link rel="stylesheet" href="home_style.css?<?php echo time();?>">
        <link rel="icon" type="image/x-icon" sizes="256x256" href="images/faviconSpriteMaths256.ico">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> 
    </head>
    <body>
        <br>
        <br>
        <br>
        <br>
        <button id = "switcher" class="switchButton" style="display:none;">Switch to other</button>
        <div class="tests-window">
            <div class="new">
            <button id="return"></button>
                <div id ="nt" class="new-tests">
                    <div class="test_buttons" id="years">
                        <div>
                        <button id="to_basic" class="header_buttons" >Basic</button>
                        </div>
                        <div>
                        <button id="to_year9" class="header_buttons">Year 9</button>
                        </div>
                        <div>
                        <button id="to_year10" class="header_buttons">Year 10</button>
                        </div>
                        <div>
                        <button id="to_year11" class="header_buttons" >NCEA LVL 1</button>
                        </div>
                        <div>
                        <button id="to_year12" class="header_buttons" >NCEA LVL 2</button>
                        </div>
                        <div>
                        <button id="to_year13" class="header_buttons" >NCEA LVL 3</button>
                        </div>
                        <div>
                        <button id="to_scholarship" class="header_buttons">Scholarship</button>
                        </div>
                    </div>
                    <div class="test_buttons" id="BASIC" style="display: none">
                        <div>
                        <button id ="basic_header" disabled>Basic Subjects</button>
                        </div>
                        <div>
                        <button id="to_basic_arithmetic">Arithmetic</button>
                        </div>
                        <div>
                        <button id="to_basic_conversions">Conversions</button>
                        </div>
                        <div>
                        <button id="to_basic_truthstatements">Logical Reasoning</button>
                        </div>
                        <div>
                        <button id="to_basic_sets">Sets</button>
                        </div>
                        <div>
                        <button id="to_basic_functions">Functions</button>
                        </div>
                        <div>
                        <button id="to_basic_naturalnumbers">Natural Numbers</button>
                        </div>
                        <div>
                        <button id="to_basic_integernumbers">Integer Numbers</button>
                        </div>
                        <div>
                        <button id="to_basic_rationalnumbers">Rational Numbers</button>
                        </div>
                        <div>
                        <button id="to_basic_realnumbers">Real Numbers</button>
                        </div>
                    </div>
                    <div class="test_buttons" id="YR9" style="display: none">
                        <div>
                        <button id ="yr9_header" disabled>Year 9 Subjects</button>
                        </div>
                        <div>
                        <button id="to_year9_number">Number</button>
                        </div>
                        <div>
                        <button id="to_year9_measurement">Measurement</button>
                        </div>
                        <div>
                        <button id="to_year9_geometry">Geometry</button>
                        </div>
                        <div>
                        <button id="to_year9_algebra">Algebra</button>
                        </div>
                        <div>
                        <button id="to_year9_statistics">Statistics</button>
                        </div>
                    </div>
                    <div class="test_buttons" id="YR10" style="display: none">
                        <div>
                        <button id ="yr10_header" disabled>Year 10 Subjects</button>
                        </div>
                        <div>
                        <button id="to_year10_number">Number</button>
                        </div>
                        <div>
                        <button id="to_year10_measurement">Measurement</button>
                        </div>
                        <div>
                        <button id="to_year10_geometry">Geometry</button>
                        </div>
                        <div>
                        <button id="to_year10_algebra">Algebra</button>
                        </div>
                        <div>
                        <button id="to_year10_statistics">Statistics</button>
                        </div>
                    </div>
                    <div class="test_buttons" id="NCEALVL1" style="display: none">
                        <div>
                        <button id ="year11_header" disabled>NCEA Level 1 Subjects</button>
                        </div>
                        <div>
                        <button id="to_NCEALVL1_algebra">Algebra</button>
                        </div>
                        <div>
                        <button id="to_NCEALVL1_tablesequationsandgraphs">Tables, Equations and Graphs</button>
                        </div>
                        <div>
                        <button id="to_NCEALVL1_geometricreasoning">Geometric Reasoning</button>
                        </div>
                        <div>
                        <button id="to_NCEALVL1_chanceanddata">Chance and Data</button>
                        </div>
                        <div>
                        <button id="to_NCEALVL1_numeracy">Numeracy</button>
                        </div>
                        <div>
                        <button id="to_NCEALVL1_linearalgebra">Linear Algebra</button>
                        </div>
                        <div>
                        <button id="to_NCEALVL1_measurement">Measurement</button>
                        </div>
                        <div>
                        <button id="to_NCEALVL1_rightangledtriangles">Right-Angled Triangles</button>
                        </div>
                        <div>
                        <button id="to_NCEALVL1_geometricrepresentations">Geometric Representations</button>
                        </div>
                        <div>
                        <button id="to_NCEALVL1_transformationgeometry">Transformation Geometry</button>
                        </div>
                        <div>
                        <button id="to_NCEALVL1_chance">Chance</button>
                        </div>
                    </div>
                    <div class="test_buttons" id="NCEALVL2" style="display: none">
                        <div>
                        <button id="year12_header" disabled >NCEA Level 2 Subjects</button>
                        </div>
                        <div>
                        <button id="to_NCEALVL2_algebra">Algebra</button>
                        </div>
                        <div>
                        <button id="to_NCEALVL2_calculus">Calculus</button>
                        </div>
                        <div>
                        <button id="to_NCEALVL2_probability">Probability</button>
                        </div>
                        <div>
                        <button id="to_NCEALVL2_geometry">Geometry</button>
                        </div>
                        <div>
                        <button id="to_NCEALVL2_sequencesandseries">Sequences and Series</button>
                        </div>
                        <div>
                        <button id="to_NCEALVL2_graphs">Graphs</button>
                        </div>
                        <div>
                        <button id="to_NCEALVL2_trigonometry">Trigonometry</button>
                        </div>
                        <div>
                        <button id="to_NCEALVL2_networks">Networks</button>
                        </div>
                        <div>
                        <button id="to_NCEALVL2_chance">Chance</button>
                        </div>
                        <div>
                        <button id="to_NCEALVL2_systemsofequations">Systems of Equations</button>
                        </div>
                    </div>
                    <div class="test_buttons" id="NCEALVL3" style="display: none">
                        <div>
                        <button id="year13_header" disabled>NCEA Level 3 Subjects</button>
                        </div>
                        <div>
                        <button id="to_NCEALVL3_algebraofcomplexnumbers">Algebra of Complex Numbers</button>
                        </div>
                        <div>
                        <button id="to_NCEALVL3_differentiation">Differentiation</button>
                        </div>
                        <div>
                        <button id="to_NCEALVL3_integration">Integration</button>
                        </div>
                        <div>
                        <button id="to_NCEALVL3_probabilityconcepts">Probability Concepts</button>
                        </div>
                        <div>
                        <button id="to_NCEALVL3_probabilitydistributions">Probability Distributions</button>
                        </div>
                        <div>
                        <button id="to_NCEALVL3_conicsections">Conic Sections</button>
                        </div>
                        <div>
                        <button id="to_NCEALVL3_linearprogramming">Linear Programming</button>
                        </div>
                        <div>
                        <button id="to_NCEALVL3_trigonometricmethods">Trigonometric Methods</button>
                        </div>
                        <div>
                        <button id="to_NCEALVL3_criticalpathanalysis">Critical Path Analysis</button>
                        </div>
                        <div>
                        <button id="to_NCEALVL3_timeseries">Time Series</button>
                        </div>
                        <div>
                        <button id="to_NCEALVL3_systemsofsimultaneousequations">Systems of Simultaneous Equations</button>
                        </div>
                    </div>
                    <?php

                    createTestLevelBlocks($BasicArithmetic, $BasicArithmeticName.' Tests', 'BASIC/Arithmetic');
                    createTestLevelBlocks($BasicConversions, $BasicConversionsName.' Tests', 'BASIC/Conversions');
                    createTestLevelBlocks($BasicTruthStatements, $BasicTruthStatementsName.' Tests', 'BASIC/TruthStatements');
                    createTestLevelBlocks($BasicSets, $BasicSetsName.' Tests', 'BASIC/Sets');
                    createTestLevelBlocks($BasicFunctions, $BasicFunctionsName.' Tests', 'BASIC/Functions');
                    createTestLevelBlocks($BasicNaturalNumbers, $BasicNaturalNumbersName.' Tests', 'BASIC/NaturalNumbers');
                    createTestLevelBlocks($BasicIntegerNumbers, $BasicIntegerNumbersName.' Tests', 'BASIC/IntegerNumbers');
                    createTestLevelBlocks($BasicRationalNumbers, $BasicRationalNumbersName.' Tests', 'BASIC/RationalNumbers');
                    createTestLevelBlocks($BasicRealNumbers, $BasicRealNumbersName.' Tests', 'BASIC/RealNumbers');

                    createTestLevelBlocks($YR9Number, $YR9NumberName.' Tests', 'YR9/Number');
                    createTestLevelBlocks($YR9Measurement, $YR9MeasurementName.' Tests', 'YR9/Measurement');
                    createTestLevelBlocks($YR9Geometry, $YR9GeometryName.' Tests', 'YR9/Geometry');
                    createTestLevelBlocks($YR9Algebra, $YR9AlgebraName.' Tests', 'YR9/Algebra');
                    createTestLevelBlocks($YR9Statistics, $YR9StatisticsName.' Tests', 'YR9/Statistics');

                    createTestLevelBlocks($YR10Number, $YR10NumberName.' Tests', 'YR10/Number');
                    createTestLevelBlocks($YR10Measurement, $YR10MeasurementName.' Tests', 'YR10/Measurement');
                    createTestLevelBlocks($YR10Geometry, $YR10GeometryName.' Tests', 'YR10/Geometry');
                    createTestLevelBlocks($YR10Algebra, $YR10AlgebraName.' Tests', 'YR10/Algebra');
                    createTestLevelBlocks($YR10Statistics, $YR10StatisticsName.' Tests', 'YR10/Statistics');

                    createTestLevelBlocks($NCEALVL1GeometricReasoning, $NCEALVL1GeometricReasoningName.' Tests', 'NCEALVL1/GeometricReasoning');
                    createTestLevelBlocks($NCEALVL1Numeracy, $NCEALVL1NumeracyName.' Tests', 'NCEALVL1/Numeracy');
                    createTestLevelBlocks($NCEALVL1Algebra, $NCEALVL1AlgebraName.' Tests', 'NCEALVL1/Algebra');
                    createTestLevelBlocks($NCEALVL1TablesEquationsAndGraphs, $NCEALVL1TablesEquationsAndGraphsName.' Tests', 'NCEALVL1/TablesEquationsAndGraphs');
                    createTestLevelBlocks($NCEALVL1LinearAlgebra, $NCEALVL1LinearAlgebraName.' Tests', 'NCEALVL1/LinearAlgebra');
                    createTestLevelBlocks($NCEALVL1Measurement, $NCEALVL1MeasurementName.' Tests', 'NCEALVL1/Measurement');
                    createTestLevelBlocks($NCEALVL1RightAngledTriangles, $NCEALVL1RightAngledTrianglesName.' Tests', 'NCEALVL1/RightAngledTriangles');
                    createTestLevelBlocks($NCEALVL1GeometricRepresentations, $NCEALVL1GeometricRepresentationsName.' Tests', 'NCEALVL1/GeometricRepresentations');
                    createTestLevelBlocks($NCEALVL1TransformationGeometry, $NCEALVL1TransformationGeometryName.' Tests', 'NCEALVL1/TransformationGeometry');
                    createTestLevelBlocks($NCEALVL1ChanceAndData, $NCEALVL1ChanceAndDataName.' Tests', 'NCEALVL1/ChanceAndData');
                    createTestLevelBlocks($NCEALVL1Chance, $NCEALVL1ChanceName.' Tests', 'NCEALVL1/Chance');

                    createTestLevelBlocks($NCEALVL2Geometry, $NCEALVL2GeometryName.' Tests', 'NCEALVL2/Geometry');
                    createTestLevelBlocks($NCEALVL2SequencesAndSeries, $NCEALVL2SequencesAndSeriesName.' Tests', 'NCEALVL2/Sequences');
                    createTestLevelBlocks($NCEALVL2Algebra, $NCEALVL2AlgebraName.' Tests', 'NCEALVL2/Algebra');
                    createTestLevelBlocks($NCEALVL2Graphs, $NCEALVL2GraphsName.' Tests', 'NCEALVL2/Graphs');
                    createTestLevelBlocks($NCEALVL2Trigonometry, $NCEALVL2TrigonometryName.' Tests', 'NCEALVL2/Trigonometry');
                    createTestLevelBlocks($NCEALVL2Networks, $NCEALVL2NetworksName.' Tests', 'NCEALVL2/Networks');
                    createTestLevelBlocks($NCEALVL2Calculus, $NCEALVL2CalculusName.' Tests', 'NCEALVL2/Calculus');
                    createTestLevelBlocks($NCEALVL2Probability, $NCEALVL2ProbabilityName.' Tests', 'NCEALVL2/Probability');
                    createTestLevelBlocks($NCEALVL2SystemsOfEquations, $NCEALVL2SystemsOfEquationsName.' Tests', 'NCEALVL2/SystemsOfEquations');
                    createTestLevelBlocks($NCEALVL2Chance, $NCEALVL2ChanceName.' Tests', 'NCEALVL2/Chance');

                    createTestLevelBlocks($NCEALVL3ConicSections, $NCEALVL3ConicSectionsName.' Tests', 'NCEALVL3/ConicSections');
                    createTestLevelBlocks($NCEALVL3LinearProgramming, $NCEALVL3LinearProgrammingName.' Tests', 'NCEALVL3/LinearProgramming');
                    createTestLevelBlocks($NCEALVL3TrigonometricMethods, $NCEALVL3TrigonometricMethodsName.' Tests', 'NCEALVL3/TrigonometricMethods');
                    createTestLevelBlocks($NCEALVL3CriticalPathAnalysis, $NCEALVL3CriticalPathAnalysisName.' Tests', 'NCEALVL3/CriticalPathAnalysis');
                    createTestLevelBlocks($NCEALVL3AlgebraOfComplexNumbers, $NCEALVL3AlgebraOfComplexNumbersName.' Tests', 'NCEALVL3/AlgebraOfComplexNumbers');
                    createTestLevelBlocks($NCEALVL3Differentiation, $NCEALVL3DifferentiationName.' Tests', 'NCEALVL3/Differentiation');
                    createTestLevelBlocks($NCEALVL3Integration, $NCEALVL3IntegrationName.' Tests', 'NCEALVL3/Integration');
                    createTestLevelBlocks($NCEALVL3TimeSeries, $NCEALVL3TimeSeriesName.' Tests', 'NCEALVL3/TimeSeries');
                    createTestLevelBlocks($NCEALVL3ProbabilityConcepts, $NCEALVL3ProbabilityConceptsName.' Tests', 'NCEALVL3/ProbabilityConcepts');
                    createTestLevelBlocks($NCEALVL3ProbabilityDistributions, $NCEALVL3ProbabilityDistributionsName.' Tests', 'NCEALVL3/ProbabilityDistributions');
                    createTestLevelBlocks($NCEALVL3SystemsOfSimultaneousEquations, $NCEALVL3SystemsOfSimultaneousEquationsName.' Tests', 'NCEALVL3/SystemsOfSimultaneousEquations');

                    

                    createTestLevelBlocks($ScholarshipSkills, $ScholarshipName.' Tests', 'SCHOL'); 
                    ?>

                </div>

                <div id = "ne" class="new-exams" style="display: none">
                    <?php

                    createExamLevelBlocks($BasicExams, $BasicName.' Exams', 'BASIC');
                    createExamLevelBlocks($YR9Exams, $YR9Name.' Exams', 'YR9');
                    createExamLevelBlocks($YR10Exams, $YR10Name.' Exams', 'YR10');
                    createExamLevelBlocks($NCEALVL1Exams, $NCEALVL1Name.' Exams', 'NCEALVL1');
                    createExamLevelBlocks($NCEALVL2Exams, $NCEALVL2Name.' Exams', 'NCEALVL2');
                    createExamLevelBlocks($NCEALVL3Exams, $NCEALVL3Name.' Exams', 'NCEALVL3');
                    createExamLevelBlocks($ScholarshipExams, $ScholarshipName.' Exams', 'SCHOL'); 

                    ?>

                </div>
            </div>
            <div class="saved-tests">
                <?php

                createSavedTests($test_types, $test_IDs, $test_subAnswers, $test_saveddates);

                ?>
            </div>
            <div class="fortutor-tests" style="display: none">
                <?php

                //createSavedTests($tutortest_types, $tutortest_IDs, $tutortest_subAnswers, $tutortest_saveddates);

                ?>
            </div>
            <div class="marked-tests" style="display: none">
                <?php

                //createSavedTests($markedstudenttest_types, $markedstudenttest_IDs, $markedstudenttest_subAnswers, $markedstudenttest_saveddates);

                ?>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                //List of all possible testbutton ids
                var button_ids = <?php echo json_encode($testCodeNames);?>; 
                //List of saved testbutton ids
                var test_types = <?php echo json_encode($test_types);?>;
            
                var returnButton = document.getElementById('return');
                var yearDiv = document.getElementById('years');

                //Start Divs
                var basicDiv = document.getElementById('BASIC');
                var year9Div = document.getElementById('YR9');
                var year10Div = document.getElementById('YR10');
                var NCEALVL1Div = document.getElementById('NCEALVL1');
                var NCEALVL2Div = document.getElementById('NCEALVL2');
                var NCEALVL3Div = document.getElementById('NCEALVL3');
                var scholDiv = document.getElementById('test_SCHOL');

                //Basic
                var BASICArithmeticDiv = document.getElementById('test_BASIC/Arithmetic');
                var BASICConversionsDiv = document.getElementById('test_BASIC/Conversions');
                var BASICTruthStatementsDiv = document.getElementById('test_BASIC/TruthStatements');
                var BASICSetsDiv = document.getElementById('test_BASIC/Sets');
                var BASICFunctionsDiv = document.getElementById('test_BASIC/Functions');
                var BASICNaturalNumbersDiv = document.getElementById('test_BASIC/NaturalNumbers');
                var BASICIntegerNumbersDiv = document.getElementById('test_BASIC/IntegerNumbers');
                var BASICRationalNumbersDiv = document.getElementById('test_BASIC/RationalNumbers');
                var BASICRealNumbersDiv = document.getElementById('test_BASIC/RealNumbers');

                var buttonToBASICArithmetic = document.getElementById('to_basic_arithmetic');
                var buttonToBASICConversions = document.getElementById('to_basic_conversions');
                var buttonToBASICTruthStatements = document.getElementById('to_basic_truthstatements');
                var buttonToBASICSets = document.getElementById('to_basic_sets');
                var buttonToBASICFunctions = document.getElementById('to_basic_functions');
                var buttonToBASICNaturalNumbers = document.getElementById('to_basic_naturalnumbers');
                var buttonToBASICIntegerNumbers = document.getElementById('to_basic_integernumbers');
                var buttonToBASICRationalNumbers = document.getElementById('to_basic_rationalnumbers');
                var buttonToBASICRealNumbers = document.getElementById('to_basic_realnumbers');

                //Year 9
                var YR9NumberDiv = document.getElementById('test_YR9/Number');
                var YR9MeasurementDiv = document.getElementById('test_YR9/Measurement');
                var YR9GeometryDiv = document.getElementById('test_YR9/Geometry');
                var YR9AlgebraDiv = document.getElementById('test_YR9/Algebra');
                var YR9StatisticsDiv = document.getElementById('test_YR9/Statistics');

                var buttonToYR9Number = document.getElementById('to_year9_number');
                var buttonToYR9Measurement = document.getElementById('to_year9_measurement');
                var buttonToYR9Geometry = document.getElementById('to_year9_geometry');
                var buttonToYR9Algebra = document.getElementById('to_year9_algebra');
                var buttonToYR9Statistics = document.getElementById('to_year9_statistics');

                //Year 10
                var YR10NumberDiv = document.getElementById('test_YR10/Number');
                var YR10MeasurementDiv = document.getElementById('test_YR10/Measurement');
                var YR10GeometryDiv = document.getElementById('test_YR10/Geometry');
                var YR10AlgebraDiv = document.getElementById('test_YR10/Algebra');
                var YR10StatisticsDiv = document.getElementById('test_YR10/Statistics');

                var buttonToYR10Number = document.getElementById('to_year10_number');
                var buttonToYR10Measurement = document.getElementById('to_year10_measurement');
                var buttonToYR10Geometry = document.getElementById('to_year10_geometry');
                var buttonToYR10Algebra = document.getElementById('to_year10_algebra');
                var buttonToYR10Statistics = document.getElementById('to_year10_statistics');

                //NCEA LVL 1
                var NCEALVL1NumeracyDiv = document.getElementById('test_NCEALVL1/Numeracy');
                var NCEALVL1AlgebraDiv = document.getElementById('test_NCEALVL1/Algebra');
                var NCEALVL1TablesEquationsAndGraphsDiv = document.getElementById('test_NCEALVL1/TablesEquationsAndGraphs');
                var NCEALVL1LinearAlgebraDiv = document.getElementById('test_NCEALVL1/LinearAlgebra');
                var NCEALVL1MeasurementDiv = document.getElementById('test_NCEALVL1/Measurement');
                var NCEALVL1GeometricReasoningDiv = document.getElementById('test_NCEALVL1/GeometricReasoning');
                var NCEALVL1RightAngledTrianglesDiv = document.getElementById('test_NCEALVL1/RightAngledTriangles');
                var NCEALVL1GeometricRepresentationsDiv = document.getElementById('test_NCEALVL1/GeometricRepresentations');
                var NCEALVL1TransformationGeometryDiv = document.getElementById('test_NCEALVL1/TransformationGeometry');
                var NCEALVL1ChanceAndDataDiv = document.getElementById('test_NCEALVL1/ChanceAndData');
                var NCEALVL1ChanceDiv = document.getElementById('test_NCEALVL1/Chance');

                var buttonToNCEALVL1GeometricReasoning = document.getElementById('to_NCEALVL1_geometricreasoning');
                var buttonToNCEALVL1Numeracy = document.getElementById('to_NCEALVL1_numeracy');
                var buttonToNCEALVL1Algebra = document.getElementById('to_NCEALVL1_algebra');
                var buttonToNCEALVL1TablesEquationsAndGraphs = document.getElementById('to_NCEALVL1_tablesequationsandgraphs');
                var buttonToNCEALVL1LinearAlgebra = document.getElementById('to_NCEALVL1_linearalgebra');
                var buttonToNCEALVL1Measurement = document.getElementById('to_NCEALVL1_measurement');
                var buttonToNCEALVL1RightAngledTriangles = document.getElementById('to_NCEALVL1_rightangledtriangles');
                var buttonToNCEALVL1GeometricRepresentations = document.getElementById('to_NCEALVL1_geometricrepresentations');
                var buttonToNCEALVL1TransformationGeometry = document.getElementById('to_NCEALVL1_transformationgeometry');
                var buttonToNCEALVL1ChanceAndData = document.getElementById('to_NCEALVL1_chanceanddata');
                var buttonToNCEALVL1Chance = document.getElementById('to_NCEALVL1_chance');


                //NCEA LVL 2
                var NCEALVL2GeometryDiv = document.getElementById('test_NCEALVL2/Geometry');
                var NCEALVL2GraphsDiv = document.getElementById('test_NCEALVL2/Graphs');
                var NCEALVL2SequencesDiv = document.getElementById('test_NCEALVL2/Sequences');
                var NCEALVL2TrigonometryDiv = document.getElementById('test_NCEALVL2/Trigonometry');
                var NCEALVL2NetworksDiv = document.getElementById('test_NCEALVL2/Networks');
                var NCEALVL2AlgebraDiv = document.getElementById('test_NCEALVL2/Algebra');
                var NCEALVL2CalculusDiv = document.getElementById('test_NCEALVL2/Calculus');
                var NCEALVL2ProbabilityDiv = document.getElementById('test_NCEALVL2/Probability');
                var NCEALVL2SystemsOfEquationsDiv = document.getElementById('test_NCEALVL2/SystemsOfEquations');
                var NCEALVL2ChanceDiv = document.getElementById('test_NCEALVL2/Chance');

                var buttonToNCEALVL2Geometry = document.getElementById('to_NCEALVL2_geometry');
                var buttonToNCEALVL2Graphs = document.getElementById('to_NCEALVL2_graphs');
                var buttonToNCEALVL2Sequences = document.getElementById('to_NCEALVL2_sequencesandseries');
                var buttonToNCEALVL2Trigonometry = document.getElementById('to_NCEALVL2_trigonometry');
                var buttonToNCEALVL2Networks = document.getElementById('to_NCEALVL2_networks');
                var buttonToNCEALVL2Algebra = document.getElementById('to_NCEALVL2_algebra');
                var buttonToNCEALVL2Calculus = document.getElementById('to_NCEALVL2_calculus');
                var buttonToNCEALVL2Probability = document.getElementById('to_NCEALVL2_probability');
                var buttonToNCEALVL2SystemsOfEquations = document.getElementById('to_NCEALVL2_systemsofequations');
                var buttonToNCEALVL2Chance = document.getElementById('to_NCEALVL2_chance');

                //NCEA LVL 3
                var NCEALVL3ConicSectionsDiv = document.getElementById('test_NCEALVL3/ConicSections');
                var NCEALVL3LinearProgrammingDiv = document.getElementById('test_NCEALVL3/LinearProgramming');
                var NCEALVL3TrigonometricMethodsDiv = document.getElementById('test_NCEALVL3/TrigonometricMethods');
                var NCEALVL3CriticalPathAnalysisDiv = document.getElementById('test_NCEALVL3/CriticalPathAnalysis');
                var NCEALVL3AlgebraOfComplexNumbersDiv = document.getElementById('test_NCEALVL3/AlgebraOfComplexNumbers');
                var NCEALVL3DifferentiationDiv = document.getElementById('test_NCEALVL3/Differentiation');
                var NCEALVL3IntegrationDiv = document.getElementById('test_NCEALVL3/Integration');
                var NCEALVL3TimeSeriesDiv = document.getElementById('test_NCEALVL3/TimeSeries');
                var NCEALVL3ProbabilityConceptsDiv = document.getElementById('test_NCEALVL3/ProbabilityConcepts');
                var NCEALVL3ProbabilityDistributionsDiv = document.getElementById('test_NCEALVL3/ProbabilityDistributions');
                var NCEALVL3SystemsOfSimultaneousEquationsDiv = document.getElementById('test_NCEALVL3/SystemsOfSimultaneousEquations');

                var buttonToNCEALVL3ConicSections = document.getElementById('to_NCEALVL3_conicsections');
                var buttonToNCEALVL3LinearProgramming = document.getElementById('to_NCEALVL3_linearprogramming');
                var buttonToNCEALVL3TrigonometricMethods = document.getElementById('to_NCEALVL3_trigonometricmethods');
                var buttonToNCEALVL3CriticalPathAnalysis = document.getElementById('to_NCEALVL3_criticalpathanalysis');
                var buttonToNCEALVL3AlgebraOfComplexNumbers = document.getElementById('to_NCEALVL3_algebraofcomplexnumbers');
                var buttonToNCEALVL3Differentiation = document.getElementById('to_NCEALVL3_differentiation');
                var buttonToNCEALVL3Integration = document.getElementById('to_NCEALVL3_integration');
                var buttonToNCEALVL3TimeSeries = document.getElementById('to_NCEALVL3_timeseries');
                var buttonToNCEALVL3ProbabilityConcepts = document.getElementById('to_NCEALVL3_probabilityconcepts');
                var buttonToNCEALVL3ProbabilityDistributions = document.getElementById('to_NCEALVL3_probabilitydistributions');
                var buttonToNCEALVL3SystemsOfSimultaneousEquations = document.getElementById('to_NCEALVL3_systemsofsimultaneousequations');

                var buttonToBasic = document.getElementById('to_basic');
                var buttonToYr9 = document.getElementById('to_year9');
                var buttonToYr10 = document.getElementById('to_year10');
                var buttonToYr11 = document.getElementById('to_year11');
                var buttonToYr12 = document.getElementById('to_year12');
                var buttonToYr13 = document.getElementById('to_year13');
                var buttonToSchol = document.getElementById('to_scholarship');

                const btnSwitch = document.getElementById('switcher');
                const divTests = document.getElementById('nt');
                const divExams = document.getElementById('ne');



                var breadcrumbs = [yearDiv];
                //Just write it in the HTML code that all display styles are none 
                //and the year Div is however NOT none
                returnButton.style.display="none";
                

                //Return Button
                returnButton.addEventListener('click', () =>  {
                    buttonPressed(breadcrumbs[breadcrumbs.length - 2]);
                });

                btnSwitch.addEventListener('click', () =>  {
                    switchThis();
                });

                //Buttons on Home Screen
                buttonToBasic.addEventListener('click', () =>  {
                    buttonPressed(basicDiv);
                    scrollToTop();
                });
                
                buttonToYr9.addEventListener('click', () =>  {
                    buttonPressed(year9Div);
                    scrollToTop();
                });

                buttonToYr10.addEventListener('click', () =>  {
                    buttonPressed(year10Div);
                    scrollToTop();
                });

                buttonToYr11.addEventListener('click', () =>  {
                    buttonPressed(NCEALVL1Div);
                    scrollToTop();
                });

                buttonToYr12.addEventListener('click', () =>  {
                    buttonPressed(NCEALVL2Div);
                    scrollToTop();
                });

                buttonToYr13.addEventListener('click', () =>  {
                    buttonPressed(NCEALVL3Div);
                    scrollToTop();
                });

                buttonToSchol.addEventListener('click', () =>  {
                    buttonPressed(scholDiv);
                    scrollToTop();
                });

                //Buttons on Basic Test div
                
                buttonToBASICArithmetic.addEventListener('click', () =>  {
                    buttonPressed(BASICArithmeticDiv);
                    scrollToTop();
                });

                buttonToBASICConversions.addEventListener('click', () =>  {
                    buttonPressed(BASICConversionsDiv);
                    scrollToTop();
                });

                buttonToBASICTruthStatements.addEventListener('click', () =>  {
                    buttonPressed(BASICTruthStatementsDiv);
                    scrollToTop();
                });

                buttonToBASICSets.addEventListener('click', () =>  {
                    buttonPressed(BASICSetsDiv);
                    scrollToTop();
                });

                buttonToBASICFunctions.addEventListener('click', () =>  {
                    buttonPressed(BASICFunctionsDiv);
                    scrollToTop();
                });

                buttonToBASICNaturalNumbers.addEventListener('click', () =>  {
                    buttonPressed(BASICNaturalNumbersDiv);
                    scrollToTop();
                });

                buttonToBASICIntegerNumbers.addEventListener('click', () =>  {
                    buttonPressed(BASICIntegerNumbersDiv);
                    scrollToTop();
                });

                buttonToBASICRationalNumbers.addEventListener('click', () =>  {
                    buttonPressed(BASICRationalNumbersDiv);
                    scrollToTop();
                });

                buttonToBASICRealNumbers.addEventListener('click', () =>  {
                    buttonPressed(BASICRealNumbersDiv);
                    scrollToTop();
                });

                //Buttons on YR9 Test div
                buttonToYR9Number.addEventListener('click', () =>  {
                    buttonPressed(YR9NumberDiv);
                    scrollToTop();
                });

                buttonToYR9Measurement.addEventListener('click', () =>  {
                    buttonPressed(YR9MeasurementDiv);
                    scrollToTop();
                });

                buttonToYR9Geometry.addEventListener('click', () =>  {
                    buttonPressed(YR9GeometryDiv);
                    scrollToTop();
                });

                buttonToYR9Algebra.addEventListener('click', () =>  {
                    buttonPressed(YR9AlgebraDiv);
                    scrollToTop();
                });

                buttonToYR9Statistics.addEventListener('click', () =>  {
                    buttonPressed(YR9StatisticsDiv);
                    scrollToTop();
                });

                //Buttons on YR10 Test div
                buttonToYR10Number.addEventListener('click', () =>  {
                    buttonPressed(YR10NumberDiv);
                    scrollToTop();
                });

                buttonToYR10Measurement.addEventListener('click', () =>  {
                    buttonPressed(YR10MeasurementDiv);
                    scrollToTop();
                });

                buttonToYR10Geometry.addEventListener('click', () =>  {
                    buttonPressed(YR10GeometryDiv);
                    scrollToTop();
                });

                buttonToYR10Algebra.addEventListener('click', () =>  {
                    buttonPressed(YR10AlgebraDiv);
                    scrollToTop();
                });

                buttonToYR10Statistics.addEventListener('click', () =>  {
                    buttonPressed(YR10StatisticsDiv);
                    scrollToTop();
                });

                //Buttons on NCEALVL1 Test div
                buttonToNCEALVL1GeometricReasoning.addEventListener('click', () =>  {
                    buttonPressed(NCEALVL1GeometricReasoningDiv);
                    scrollToTop();
                });

                buttonToNCEALVL1Numeracy.addEventListener('click', () =>  {
                    buttonPressed(NCEALVL1NumeracyDiv);
                    scrollToTop();
                });

                buttonToNCEALVL1Algebra.addEventListener('click', () =>  {
                    buttonPressed(NCEALVL1AlgebraDiv);
                    scrollToTop();
                });

                buttonToNCEALVL1TablesEquationsAndGraphs.addEventListener('click', () =>  {
                    buttonPressed(NCEALVL1TablesEquationsAndGraphsDiv);
                    scrollToTop();
                });

                buttonToNCEALVL1LinearAlgebra.addEventListener('click', () =>  {
                    buttonPressed(NCEALVL1LinearAlgebraDiv);
                    scrollToTop();
                });

                buttonToNCEALVL1Measurement.addEventListener('click', () =>  {
                    buttonPressed(NCEALVL1MeasurementDiv);
                    scrollToTop();
                });

                buttonToNCEALVL1RightAngledTriangles.addEventListener('click', () =>  {
                    buttonPressed(NCEALVL1RightAngledTrianglesDiv);
                    scrollToTop();
                });

                buttonToNCEALVL1GeometricRepresentations.addEventListener('click', () =>  {
                    buttonPressed(NCEALVL1GeometricRepresentationsDiv);
                    scrollToTop();
                });

                buttonToNCEALVL1TransformationGeometry.addEventListener('click', () =>  {
                    buttonPressed(NCEALVL1TransformationGeometryDiv);
                    scrollToTop();
                });

                buttonToNCEALVL1ChanceAndData.addEventListener('click', () =>  {
                    buttonPressed(NCEALVL1ChanceAndDataDiv);
                    scrollToTop();
                });

                buttonToNCEALVL1Chance.addEventListener('click', () =>  {
                    buttonPressed(NCEALVL1ChanceDiv);
                    scrollToTop();
                });

                

                //Buttons on NCEALVL2 Test div
                
                buttonToNCEALVL2Geometry.addEventListener('click', () =>  {
                    buttonPressed(NCEALVL2GeometryDiv);
                    scrollToTop();
                });

                buttonToNCEALVL2Graphs.addEventListener('click', () =>  {
                    buttonPressed(NCEALVL2GraphsDiv);
                    scrollToTop();
                });

                buttonToNCEALVL2Sequences.addEventListener('click', () =>  {
                    buttonPressed(NCEALVL2SequencesDiv);
                    scrollToTop();
                });

                buttonToNCEALVL2Trigonometry.addEventListener('click', () =>  {
                    buttonPressed(NCEALVL2TrigonometryDiv);
                    scrollToTop();
                });

                buttonToNCEALVL2Networks.addEventListener('click', () =>  {
                    buttonPressed(NCEALVL2NetworksDiv);
                    scrollToTop();
                });

                buttonToNCEALVL2Algebra.addEventListener('click', () =>  {
                    buttonPressed(NCEALVL2AlgebraDiv);
                    scrollToTop();
                });

                buttonToNCEALVL2Calculus.addEventListener('click', () =>  {
                    buttonPressed(NCEALVL2CalculusDiv);
                    scrollToTop();
                });

                buttonToNCEALVL2Probability.addEventListener('click', () =>  {
                    buttonPressed(NCEALVL2ProbabilityDiv);
                    scrollToTop();
                });

                buttonToNCEALVL2SystemsOfEquations.addEventListener('click', () =>  {
                    buttonPressed(NCEALVL2SystemsOfEquationsDiv);
                    scrollToTop();
                });

                buttonToNCEALVL2Chance.addEventListener('click', () =>  {
                    buttonPressed(NCEALVL2ChanceDiv);
                    scrollToTop();
                });

                //Buttons on NCEALVL3 Test div

                buttonToNCEALVL3ConicSections.addEventListener('click', () =>  {
                    buttonPressed(NCEALVL3ConicSectionsDiv);
                    scrollToTop();
                });

                buttonToNCEALVL3LinearProgramming.addEventListener('click', () =>  {
                    buttonPressed(NCEALVL3LinearProgrammingDiv);
                    scrollToTop();
                });

                buttonToNCEALVL3TrigonometricMethods.addEventListener('click', () =>  {
                    buttonPressed(NCEALVL3TrigonometricMethodsDiv);
                    scrollToTop();
                });

                buttonToNCEALVL3CriticalPathAnalysis.addEventListener('click', () =>  {
                    buttonPressed(NCEALVL3CriticalPathAnalysisDiv);
                    scrollToTop();
                });

                buttonToNCEALVL3AlgebraOfComplexNumbers.addEventListener('click', () =>  {
                    buttonPressed(NCEALVL3AlgebraOfComplexNumbersDiv);
                    scrollToTop();
                });

                buttonToNCEALVL3Differentiation.addEventListener('click', () =>  {
                    buttonPressed(NCEALVL3DifferentiationDiv);
                    scrollToTop();
                });

                buttonToNCEALVL3Integration.addEventListener('click', () =>  {
                    buttonPressed(NCEALVL3IntegrationDiv);
                    scrollToTop();
                });

                buttonToNCEALVL3TimeSeries.addEventListener('click', () =>  {
                    buttonPressed(NCEALVL3TimeSeriesDiv);
                    scrollToTop();
                });

                buttonToNCEALVL3ProbabilityConcepts.addEventListener('click', () =>  {
                    buttonPressed(NCEALVL3ProbabilityConceptsDiv);
                    scrollToTop();
                });

                buttonToNCEALVL3ProbabilityDistributions.addEventListener('click', () =>  {
                    buttonPressed(NCEALVL3ProbabilityDistributionsDiv);
                    scrollToTop();
                });

                buttonToNCEALVL3SystemsOfSimultaneousEquations.addEventListener('click', () =>  {
                    buttonPressed(NCEALVL3SystemsOfSimultaneousEquationsDiv);
                    scrollToTop();
                });
                
                function buttonPressed(el){
                    hideAllDivExc(el);
                    adjustBreadCrumbs(el);
                    if(breadcrumbs.length==1){
                        btnSwitch.style.display='none';
                    } else {
                        btnSwitch.style.display='none';
                    }
                }


                function hideAllDivExc(el){
                    //breadcrumbs[breadcrumbs.length-1].fadeOut();
                    breadcrumbs[breadcrumbs.length-1].style.display='none';
                    el.style.display='grid';
                    if(yearDiv.style.display=='none'){
                        returnButton.style.display='inline';
                    } else {
                        returnButton.style.display='none';
                    }
                }
                
                function adjustBreadCrumbs(el){
                    if(!breadcrumbs.includes(el)){
                        breadcrumbs.push(el)
                    } else {
                        breadcrumbs.pop();
                    }
                }

                for(const [id, sameid] of Object.entries(button_ids)){
                    disableButton(sameid);
                }

                function switchThis() 
                {
                    if(divExams.style.display == "none")
                    {
                        divTests.style.display = "none";
                        divExams.style.display = "inline";
                        returnButton.style.display = "none";
                    } else 
                    {
                        divTests.style.display = "inline";
                        divExams.style.display = "none";
                        returnButton.style.display = "none";
                    }
                }

                function scrollToTop()
                {
                    $("html, body").animate({ 
                        scrollTop: 0 
                    }, 400);
                }

                /**
                * Disables the buttons for tests that have already an active test available
                * 
                * @param string id of button_ids
                */
                function disableButton(item) 
                {
                    if(test_types.includes(item)){
                        document.getElementById(item).disabled = true;
                    } else {
                        document.getElementById(item).disabled = false;
                    }
                }

            })


        </script>
    </body>
</html>

<?php

    require 'Footer/footer.php';
    
?>