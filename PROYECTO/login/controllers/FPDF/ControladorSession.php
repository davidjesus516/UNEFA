<?php
require_once __DIR__ . '../../../model/ModeloSessionHistory.php';

class ControladorSessionHistory {
    public static function obtenerHistorial() {
        return ModeloSessionHistory::obtenerHistorial();
    }
}
