<?php
class GabimAutentikim extends Exception {
    public function mesazhi() {
        return "Gabim gjatë hyrjes: " . $this->getMessage();
    }
}

class GabimRegjistrim extends Exception {
    public function mesazhi() {
        return "Gabim gjatë regjistrimit: " . $this->getMessage();
    }
}

class GabimDatabaze extends Exception {
    public function mesazhi() {
        return "Gabim me lidhjen e databazës: " . $this->getMessage();
    }
}
?>
