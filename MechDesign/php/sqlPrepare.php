<?php


function bindFetch($stmt, $valArray) {
    
    prepareStatment($stmt, $valArray);
    mysqli_stmt_execute($stmt);
    
    $array = array();
    
    if($stmt instanceof mysqli_stmt)
    {
        $stmt->store_result();
        
        $variables = array();
        $data = array();
        $meta = $stmt->result_metadata();
        
        while($field = $meta->fetch_field())
            $variables[] = &$data[$field->name]; // pass by reference
        
        call_user_func_array(array($stmt, 'bind_result'), $variables);
        
        $i=0;
        while($stmt->fetch()) {
            $array[$i] = array();
            foreach($data as $k=>$v)
                $array[$i][$k] = $v;
            $i++;
        }
    }
    elseif($stmt instanceof mysqli_result)
    {
        while($row = $stmt->fetch_assoc())
            $array[] = $row;
    }
    
    mysqli_stmt_close($stmt);
    return $array;
}


function bindExecute($stmt, $valArray) {  
    
    prepareStatment($stmt, $valArray);
    
    return mysqli_stmt_execute($stmt);
}


function prepareStatment($stmt, $valArray) {
    
    $bindTypes = '';
    $valArrayRefs = array();
    
    foreach ($valArray as $key => $val) {
        $bindTypes .= gettype($val)[0];
        
        if (strnatcmp(phpversion(),'5.3') >= 0) { //Reference is required for PHP 5.3+
            $valArrayRefs[$key] = &$valArray[$key];
        }
        else {
            $valArrayRefs = $valArray;
        }
    }
    
    call_user_func_array('mysqli_stmt_bind_param', array_merge(array($stmt, $bindTypes), $valArrayRefs)); 
}