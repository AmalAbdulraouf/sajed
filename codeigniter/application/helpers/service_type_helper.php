<?php

class SERVICE_TYPE {
    const SOFTWARE = 1;
    const ELECTRONIC = 2;
    const EXTERNAL = 3;
    const WARRANTY = 4;
   
}

function get_service_type ($service) {
    if($service == 1) return 'Software برمجيات';
    if($service == 2) return 'Electronic الكترونيات';
    if($service == 3) return 'External صيانة خارجية';
    if($service == 4) return 'Warranty ضمان';
}

