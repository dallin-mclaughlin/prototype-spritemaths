<?php

$BasicName = "Basic";

$BasicArithmeticName = "Arithmetic";
$BasicArithmetic = array(
    'Addition'=>'Addition',
    'Subtraction'=>'Subtraction',
    'Multiplication'=>'Multiplication',
    'Division'=>'Division',
    'Highest_Common_Factor'=>'Highest_Common_Factor',
    'Lowest_Common_Multiple'=>'Lowest_Common_Multiple'
);

$BasicConversionsName = "Conversions";
$BasicConversions = array(
    'Time_Conversion'=>'Time_Conversion',
    'Length_Conversion'=>'Length_Conversion',
    'Area_Conversion'=>'Area_Conversion',
    'Volume_Conversion'=>'Volume_Conversion',
    'Speed_Conversion'=>'Speed_Conversion',
    'Mass_Conversion'=>'Mass_Conversion',
    'Currency_Conversion'=>'Currency_Conversion'
);

$BasicTruthStatementsName = "Logical Reasoning";
$BasicTruthStatements = array(
    
);

$BasicSetsName = "Sets";
$BasicSets = array(
    
);

$BasicFunctionsName = "Functions";
$BasicFunctions = array(
    
);

$BasicNaturalNumbersName = "Natural Numbers";
$BasicNaturalNumbers = array(
    'Identify_Natural_Numbers'=>'Identify_Natural_Numbers',
    'Ordering_Numbers'=>'Ordering_Numbers',
    'Multiplicative_Distribution'=>'Multiplicative_Distribution',
    'Combinations'=>'Combinations'
);

$BasicIntegerNumbersName = "Integer Numbers";
$BasicIntegerNumbers = array(
    'Additive_Inverses'=>'Additive_Inverses'
);

$BasicRationalNumbersName = "Rational Numbers";
$BasicRationalNumbers = array(
    'Multiplicative_Inverses'=>'Multiplicative_Inverses'
);

$BasicRealNumbersName = "Real Numbers";
$BasicRealNumbers = array(
    
);

$BasicSkills = array_merge(
    $BasicArithmetic,
    $BasicConversions,
    $BasicTruthStatements,
    $BasicSets,
    $BasicFunctions,
    $BasicNaturalNumbers,
    $BasicIntegerNumbers,
    $BasicRationalNumbers,
    $BasicRealNumbers
);

$BasicExams = array(

);

$YR9Name = "Year 9";

$YR9NumberName = "Number";
$YR9Number = array(
    
);

$YR9MeasurementName = "Measurement";
$YR9Measurement = array(

);

$YR9GeometryName = "Geometry";
$YR9Geometry = array(

);

$YR9AlgebraName = "Algebra";
$YR9Algebra = array(

);

$YR9StatisticsName = "Statistics";
$YR9Statistics = array(

);

$YR9Skills = array_merge(
    $YR9Number,
    $YR9Measurement,
    $YR9Geometry,
    $YR9Algebra,
    $YR9Statistics
);

$YR9Exams = array(

);

$YR10Name = "Year 10";

$YR10NumberName = "Number";
$YR10Number = array(
    'Fraction_Addition'=>'Fraction_Addition',
    'Fraction_Multiplication'=>'Fraction_Multiplication',
    'Fraction_Conversion'=>'Fraction_Conversion',
    'Percentage_Conversion'=>'Percentage_Conversion',
    'Determine_Sequence'=>'Determine_Sequence'
);

$YR10MeasurementName = "Measurement";
$YR10Measurement = array(
    'Basic_Area'=>'Basic_Area'
);

$YR10GeometryName = "Geometry";
$YR10Geometry = array(

);

$YR10AlgebraName = "Algebra";
$YR10Algebra = array(

);

$YR10StatisticsName = "Statistics";
$YR10Statistics = array(

);

$YR10Skills = array_merge(
    $YR10Number,
    $YR10Measurement,
    $YR10Geometry,
    $YR10Algebra,
    $YR10Statistics
);

$YR10Exams = array(

);

$NCEALVL1Name = "NCEA Level 1";

$NCEALVL1NumeracyName = "Numeracy";
$NCEALVL1Numeracy = array();

$NCEALVL1AlgebraName = "Algebra";
$NCEALVL1Algebra = array(
    'Algebra_Simple'=>'Algebra_Simple',
    'Expanding_Quadratics'=>'Expanding_Quadratics',
    'Factorising_Quadratics'=>'Factorising_Quadratics',
    'Simplifying_Exponents'=>'Simplifying_Exponents',
    'Quadratic_Roots'=>'Quadratic_Roots',
    'Factorise_Roots'=>'Factorise_Roots',
    'Perimeter_Solving'=>'Perimeter_Solving',
    'Find_Quadratic_Roots'=>'Find_Quadratic_Roots',
    'Simultaneous_Equations'=>'Simultaneous_Equations',
    'Solving_Exponents'=>'Solving_Exponents'
);

$NCEALVL1TablesEquationsAndGraphsName = "Tables, Equations and Graphs";
$NCEALVL1TablesEquationsAndGraphs = array(
    'Graph_Equations'=>'Graph_Equations',
    'Table_Equations'=>'Table_Equations',
    'Number_Patterns'=>'Number_Patterns',
    'Maxima_Minima'=>'Maxima_Minima',
    'Intercepts'=>'Intercepts'
);

$NCEALVL1LinearAlgebraName = "Linear Algebra";
$NCEALVL1LinearAlgebra = array();

$NCEALVL1MeasurementName = "Measurement";
$NCEALVL1Measurement = array();

$NCEALVL1GeometricReasoningName = "Geometric Reasoning";
$NCEALVL1GeometricReasoning = array(
    'Straight_Lines'=>'Straight_Lines'
);

$NCEALVL1RightAngledTrianglesName = "Right-Angled Triangles";
$NCEALVL1RightAngledTriangles = array(
    'Pythagoras_Theorem'=>'Pythagoras_Theorem'
);

$NCEALVL1GeometricRepresentationsName = "Geometric Representations";
$NCEALVL1GeometricRepresentations = array();

$NCEALVL1TransformationGeometryName = "Transformation Geometry";
$NCEALVL1TransformationGeometry = array();

$NCEALVL1ChanceAndDataName = "Chance and Data";
$NCEALVL1ChanceAndData = array();

$NCEALVL1ChanceName = "Elements of Chance";
$NCEALVL1Chance = array();

$NCEALVL1Skills = array_merge(
    $NCEALVL1Numeracy,
    $NCEALVL1Algebra,
    $NCEALVL1TablesEquationsAndGraphs,
    $NCEALVL1LinearAlgebra,
    $NCEALVL1Measurement,
    $NCEALVL1GeometricReasoning,
    $NCEALVL1RightAngledTriangles,
    $NCEALVL1GeometricRepresentations,
    $NCEALVL1TransformationGeometry,
    $NCEALVL1ChanceAndData,
    $NCEALVL1Chance
);

$NCEALVL1Exams = array(
    'Algebraic_Procedures'=>'Algebraic_Procedures'
    //'Tables,_Equations_and_Graphs'=>'Tables,_Equations_and_Graphs',
    //'Geometric_Reasoning'=>'Geometric_Reasoning',
    //'Chance_and_Data'=>'Chance_and_Data',
    //'Numeric_Reasoning'=>'Numeric_Reasoning',
    //'Multivariate_Data'=>'Multivariate_Data'
);

$NCEALVL2Name = "NCEA Level 2";

$NCEALVL2GeometryName = "Geometry";
$NCEALVL2Geometry = array();

$NCEALVL2GraphsName = "Graphs";
$NCEALVL2Graphs = array();

$NCEALVL2SequencesAndSeriesName = "Sequences and Series";
$NCEALVL2SequencesAndSeries = array();

$NCEALVL2TrigonometryName = "Trigonometry";
$NCEALVL2Trigonometry = array(
    'Radian_Conversion'=>'Radian_Conversion'
);

$NCEALVL2NetworksName = "Networks";
$NCEALVL2Networks = array();

$NCEALVL2AlgebraName = "Algebra";
$NCEALVL2Algebra = array(
    'Simplifying_Expressions'=>'Simplifying_Expressions',
    'Quadratic_Linear_Unknown'=>'Quadratic_Linear_Unknown',
    'Quadratic_One_Solution'=>'Quadratic_One_Solution',
    'Quadratic_Roots_Whole'=>'Quadratic_Roots_Whole',
    'Quadratic_Algebraic_Solutions'=>'Quadratic_Algebraic_Solutions'
);

$NCEALVL2CalculusName = "Calculus";
$NCEALVL2Calculus = array(
    'Polynomial_Differentiation'=>'Polynomial_Differentiation',
    'Polynomial_Integration'=>'Polynomial_Integration',
    'Distance_Speed_Acceleration'=>'Distance_Speed_Acceleration',
    'Tangent_Equations'=>'Tangent_Equations',
    'Gradient_Intersection'=>'Gradient_Intersection'
);

$NCEALVL2ProbabilityName = "Probability";
$NCEALVL2Probability = array(
    'Probability_Tables'=>'Probability_Tables',
    'Expectation'=>'Expectation',
    'Continuous_Data'=>'Continuous_Data',
    'Normal_Distribution'=>'Normal_Distribution',
    'Probability_Trees'=>'Probability_Trees'
);

$NCEALVL2SystemsOfEquationsName = "Systems Of Equations";
$NCEALVL2SystemsOfEquations = array();

$NCEALVL2ChanceName = "Chance";
$NCEALVL2Chance = array();

$NCEALVL2Skills = array_merge(
    $NCEALVL2Geometry,
    $NCEALVL2Graphs,
    $NCEALVL2SequencesAndSeries,
    $NCEALVL2Trigonometry,
    $NCEALVL2Networks,
    $NCEALVL2Algebra,
    $NCEALVL2Calculus,
    $NCEALVL2Probability,
    $NCEALVL2SystemsOfEquations,
    $NCEALVL2Chance
);

$NCEALVL2Exams = array(
    //'Algebraic_Methods'=>'Algebraic_Methods',
    //'Calculus_Methods'=>'Calculus_Methods',
    //'Probability_Methods'=>'Probability_Methods'
);

$NCEALVL3Name = "NCEA Level 3";

$NCEALVL3ConicSectionsName = "Conic Sections";
$NCEALVL3ConicSections = array();

$NCEALVL3LinearProgrammingName = "Linear Programming";
$NCEALVL3LinearProgramming = array();

$NCEALVL3TrigonometricMethodsName = "Trigonometric Methods";
$NCEALVL3TrigonometricMethods = array();

$NCEALVL3CriticalPathAnalysisName = "Critical Path Analysis";
$NCEALVL3CriticalPathAnalysis = array();

$NCEALVL3AlgebraOfComplexNumbersName = "Algebra of Complex Numbers";
$NCEALVL3AlgebraOfComplexNumbers = array(
    'Complex_Arithmetic'=>'Complex_Arithmetic',
    'Complex_Roots'=>'Complex_Roots',
    'Rectangular_Polar'=>'Rectangular_Polar',
    'Complex_Conjugate'=>'Complex_Conjugate',
    'Demoivres_Theorem'=>'Demoivres_Theorem'
);

$NCEALVL3DifferentiationName = "Differentiation";
$NCEALVL3Differentiation = array(
    'Differentiate_Expressions'=>'Differentiate_Expressions',
    'Quadratic_Optimisation'=>'Quadratic_Optimisation',
    'Parametric_Equations'=>'Parametric_Equations',
    'Chain_Rule'=>'Chain_Rule',
    'Gradient_Functions'=>'Gradient_Functions'
);

$NCEALVL3IntegrationName = "Integration";
$NCEALVL3Integration = array(
    'Integrate_Expressions'=>'Integrate_Expressions',
    'Integrate_to_Position'=>'Integrate_to_Position',
    'Limit_Integration'=>'Limit_Integration',
    'Separable_Differential_Equations'=>'Separable_Differential_Equations',
    'Trig_Integration'=>'Trig_Integration'
);

$NCEALVL3TimeSeriesName = "Time Series";
$NCEALVL3TimeSeries = array();

$NCEALVL3ProbabilityConceptsName = "Probability Concepts";
$NCEALVL3ProbabilityConcepts = array();

$NCEALVL3ProbabilityDistributionsName = "Probability Distributions";
$NCEALVL3ProbabilityDistributions = array();

$NCEALVL3SystemsOfSimultaneousEquationsName = "Systems of Simultaneous Equations";
$NCEALVL3SystemsOfSimultaneousEquations = array();

$NCEALVL3Skills = array_merge(
    $NCEALVL3ConicSections,
    $NCEALVL3LinearProgramming,
    $NCEALVL3TrigonometricMethods,
    $NCEALVL3CriticalPathAnalysis,
    $NCEALVL3AlgebraOfComplexNumbers,
    $NCEALVL3Differentiation,
    $NCEALVL3Integration,
    $NCEALVL3TimeSeries,
    $NCEALVL3ProbabilityConcepts,
    $NCEALVL3ProbabilityDistributions,
    $NCEALVL3SystemsOfSimultaneousEquations
);

$NCEALVL3Exams = array(
    //'Complex_Numbers'=>'Complex_Numbers',
    //'Differentiation_Methods'=>'Differentiation_Methods',
    //'Integration_Methods'=>'Integration_Methods',
    //'Statistically_Based_Reports'=>'Statistically_Based_Reports',
    //'Probability_Concepts'=>'Probability_Concepts',
    //'Probability_Distributions'=>'Probability_Distributions'
);

$ScholarshipName = "Scholarship";
$ScholarshipSkills = array(

);

$ScholarshipExams = array(

);

$testCodeNamesSkills = array_merge(
    $BasicSkills,
    $YR9Skills,
    $YR10Skills,
    $NCEALVL1Skills,
    $NCEALVL2Skills,
    $NCEALVL3Skills,
    $ScholarshipSkills
);

$testCodeNamesExams = array_merge(
    $BasicExams,
    $YR9Exams,
    $YR10Exams,
    $NCEALVL1Exams,
    $NCEALVL2Exams,
    $NCEALVL3Exams,
    $ScholarshipExams
);

$testCodeNames = array_merge(
    $testCodeNamesSkills,
    $testCodeNamesExams
);


?>