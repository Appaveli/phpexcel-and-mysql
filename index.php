<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require_once 'C:\xampp\htdocs\phpexcel\Classes\PHPExcel\IOFactory.php';
     

        $filename = 'accounting.xlsx'; // create a new file if you prefer a different name
        $database_name = 'your database';
        $host = 'localhost';
        $user = 'your username';
        $password = 'your password';
        

        //connect to database
        $con = mysql_connect($host, $user, $password, $database_name) or die();
        mysql_select_db($database_name, $con) or die();
        
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $objReader->setReadDataOnly(true);

        $objPHPExcel = $objReader->load($filename);
        $objWorksheet = $objPHPExcel->getActiveSheet();

        $highestRow = $objWorksheet->getHighestRow(); 
        $highestColumn = $objWorksheet->getHighestColumn(); 

        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5

        echo '<table>' . "\n";
        //set number of rows according to your data in excel
        for ($row = 1; $row <= $highestRow; ++$row)  {
            echo '<tr>' . "\n";
            $values=array();//array to storevalues

            for ($col = 0; $col <= $highestColumnIndex; ++$col) {
                 $values[] = $objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
            }
            $sql="insert into retained(NetIncome,Dividend)
                                            values('".$values[1] . "','" . $values[2] ."')";
            mysql_query($sql);
            echo '</tr>' . "\n";
        }
        echo '</table>' . "\n";
        ?>
    </body>
</html>
