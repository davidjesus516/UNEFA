<?php

require("../../model/estudiante.php");

if(isset($_POST)){
$STUDENTS_ID = $_POST["STUDENTS_ID"];   
$STUDENTS_CI =mb_strtoupper( $_POST["STUDENTS_CI"]);
$NAME = mb_strtoupper($_POST["NAME"]);
$SECOND_NAME = mb_strtoupper($_POST["SECOND_NAME"]);
$SURNAME = mb_strtoupper($_POST["SURNAME"]);
$SECOND_SURNAME = mb_strtoupper($_POST["SECOND_SURNAME"]);
$GENDER = mb_strtoupper($_POST["GENDER"]);
$BIRTHDATE = $_POST["BIRTHDATE"];
$CONTACT_PHONE = $_POST["CONTACT_PHONE"];
$EMAIL = mb_strtoupper($_POST["EMAIL"]);
$ADDRESS = mb_strtoupper($_POST["ADDRESS"]);
$MARITAL_STATUS = mb_strtoupper($_POST["MARITAL_STATUS"]);
$SEMESTER = $_POST["SEMESTER"];
$SECTION = $_POST["SECTION"];
$REGIME = $_POST["REGIME"];
$STUDENT_TYPE = $_POST["STUDENT_TYPE"];
$MILITARY_RANK = $_POST["MILITARY_RANK"];
$EMPLOYMENT = $_POST["EMPLOYMENT"];
$CAREER_ID = $_POST["CAREER_ID"];
$student = new Student();
if ($student->updateStudent($STUDENTS_ID,$STUDENTS_CI, $NAME, $SECOND_NAME, $SURNAME, $SECOND_SURNAME, $GENDER, $BIRTHDATE, $CONTACT_PHONE, $EMAIL, $ADDRESS, $MARITAL_STATUS, $SEMESTER, $SECTION, $REGIME, $STUDENT_TYPE, $MILITARY_RANK, $EMPLOYMENT, $CAREER_ID)){
    
    $row = array(
        'message' => '    
        <dialog id="message">
        <h2>Registro Editado</h2>
        <button onclick="window.dialog.close();" aria-label="close" class="x">❌</button>
        <div class="success-checkmark">
        <div class="check-icon">
            <span class="icon-line line-tip"></span>
            <span class="icon-line line-long"></span>
            <div class="icon-circle"></div>
            <div class="icon-fix"></div>
        </div>
        </div>
        </dialog>');
    $jsonstring = json_encode($row);
    echo $jsonstring;
}else{
    $row = array( 'message' =>'     
                <dialog id="message">
            <h2>Ha ocurrido un error en el registro.</h2>
            <div class="error-banmark">
            <div class="ban-icon">
                <span class="icon-line line-long-invert"></span>
                <span class="icon-line line-long"></span>
                <div class="icon-circle"></div>
                <div class="icon-fix"></div>
            </div>
            </div>
        <button onclick="window.dialog.close();" aria-label="close" class="x">❌</button>
            </dialog>');
    $jsonstring = json_encode($row);
    echo $jsonstring;
}}
?>