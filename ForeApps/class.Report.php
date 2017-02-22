<?php

class Report extends ForeVIEWS {

    public function __Public() {
        IsLogin();
        //当前模块
        $this->MyModule = 'Report';
    }
    
    /*客户统计*/
    public function CusStatistics() {
        $this->MyAction = 'CusStatistics';
    }
    
    /*消费统计*/
    public function CostStatistics() {
        $this->MyAction = 'CostStatistics';
    }
    
    /*模板热度统计*/
    public function ModelStatistics() {
        $this->MyAction = 'ModelStatistics';
    }
    
    /*行业热度统计*/
    public function ProStatistics() {
        $this->MyAction = 'ProStatistics';
    }

}
