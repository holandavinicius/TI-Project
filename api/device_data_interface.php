<?php    


require_once("./data_file_model");


interface DeviceDataInterface{

    public function ProcessData(DeviceDataModel $deviceInformationModel) : DeviceDataModel;

    
}

