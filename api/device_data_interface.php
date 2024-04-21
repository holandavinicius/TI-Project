<?php    


interface DeviceDataInterface{

    public function ProcessDataPost(DeviceDataModel $deviceInformationModel);
    public function ProcessDataGet($device) : DeviceDataModel;

    
}

