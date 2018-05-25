<?php

class Sam_Form extends Zend_Form {
    public function getArrayMessages() {
        $array = array();
        foreach ($this->getMessages() as $campo => $msgs) {
            $label = $this->getElement($campo) ? $this->getElement($campo)->getLabel() : ucwords($campo);
            foreach ($msgs as $msg) {
                if (is_array($msg)) {
                    foreach ($msg as $campo2 => $msgs2) {
                        $label2 = $this->getElement($campo2) ? $this->getElement($campo2)->getLabel() : $campo2;
                        foreach ($msgs2 as $key => $msg2) {
                            if (is_array($msg2)) {
                                foreach ($msg2 as $campo3 => $msgs3) {
                                    $label3 = $this->getElement($key) ? $this->getElement($key)->getLabel() : ucwords($key);

                                    $array[] = "[$label $label2] $label3: " . $msgs3;
                                }
                            } else {
                                $array[] = $label . $label2 . ': ' . $msg2;
                            }
                        }
                    }
                } else {
                    $array[] = $label . ': ' . $msg;
                }
            }
        }
        return $array;
    }

}