<?php
require_once("../../model/combos.php");
$combos = new Combos();
$gender = $combos->getGenderCombo();
$maritalStatus = $combos->getMaritalStatusCombo();
$nationality = $combos->getNationalityCombo();
$regime = $combos->getRegimeCombo();
$workingStatus = $combos->getWorkingStatusCombo();
$militaryRank = $combos->getMilitaryRankCombo();
$studentType = $combos->getStudentTypeCombo();
$row = array(
    'gender' => '<option value="" disabled selected>Seleccione una opción</option>'.$gender,
    'maritalStatus' => '<option value="" disabled selected>Seleccione una opción</option>'.$maritalStatus,
    'nationality' => '<option value="" disabled selected>Seleccione una opción</option>'.$nationality,
    'regime' => '<option value="" disabled selected>Seleccione una opción</option>'.$regime,
    'workingStatus' => '<option value="" disabled selected>Seleccione una opción</option>'.$workingStatus,
    'militaryRank' => '<option value="" disabled selected>Seleccione una opción</option>'.$militaryRank,
    'studentType' => '<option value="" disabled selected>Seleccione una opción</option>'.$studentType,
);
$jsonstring = json_encode($row);
echo $jsonstring;
?>