<?php

namespace Modules\Helpers
{
    function render(string $template, array $context)
    {
        global $basePath;
        extract($context);
        require_once $basePath.'Modules/templates/'.$template.'.php';
    }

    function connectToDb() 
    {
        $connectionString = 'mysql:host='.\Modules\Settings\DB_HOST.';dbname='.\Modules\Settings\DB_NAME.';charset=utf8';
        return new \PDO($connectionString, \Modules\Settings\DB_USERNAME, \Modules\Settings\DB_PASSWORD);
    }

    function apiHeaders()
    {
        header('Content-Type: application/json; charset=UTF-8');
        header('Cache-Control: no-cache, no-store, must-revalidate');
    }

    function showErrors(string $fldName, array $formData)
    {
        $errorString = '';
        if(isset($formData['__errors'][$fldName])) {
            if(is_array($formData['__errors'][$fldName])) {
                foreach ($formData['__errors'][$fldName] as $error => $value) {
                    $errorString .= '<div class="error">'.$formData['__errors'][$fldName][$error].'</div>';
                }
            } else {
                $errorString .= '<div class="error">'.$formData['__errors'][$fldName].'</div>';
            }
        }
        return $errorString;
    }

    function redirect(string $url, int $status = 302) 
    {
        header('Location: '.$url, TRUE, $status);
    }

    function getFragmentPath(string $fragment): string 
    {
        global $basePath;
        return $basePath.'Modules/templates/helpers_templates/'.$fragment.'.php';
    }

    function getOptionsForSelect($modelName, $fields, $links = NULL, $where = '', $params = NULL)
    {
        $workArray = array();
        $modelName = '\Modules\Model\\'.$modelName;
        $model = new $modelName;
        $fieldsArray = explode(', ', $fields);
        $optionName = $fieldsArray[0];
        $optionValue = $fieldsArray[1];
        
        if ($links != NULL || $where != ''){
            if($params != NULL) {
                $model->select($fields, $links, $where, $params);
            } else {
                $model->select($fields, $links, $where);
            }
        } else {
            $model->select($fields);
        }

        foreach ($model as $key => $value) {
            $workArray[$value[$optionName]] = $value[$optionValue];
        }

        return $workArray;
    }

    /**
     * 
     */
    function getPreparedSelectArray(array $selectOptions) 
    {
        $preparedArray = array();
        foreach ($selectOptions as $optionKey => $optionValue) {
            if (is_array($optionValue) && count($optionValue) === 2) {
                $keys = array_keys($optionValue);
                $preparedArray[$keys[0]] = $keys[1];
            } else if (!is_array($optionValue)) {
                    $preparedArray[$optionKey] = $optionValue;
            } else {
                return 'Array is not right';
            }
        }
        return $preparedArray;
    }



    /**
     * Блок, связанный с рендерингом формы
     */
    function getRenderedLabel($fieldName, $labelName, $fieldType = 'input')
    {
        $labelString = '';
        if($fieldType === 'checkbox') {
            $labelString = '<label class=\'form-check-label mt-2\' style="font-size: 18px;">'.$labelName.'</label>';
        } else {
            $labelString = '<div><label class=\'form-label mt-2\' style="font-size: 18px;">'.$labelName.'</label></div>';
        }

        return $labelString;
    }

    function getRenderedInput($type, $name, array $formData, $placeholder = '')
    {
        $input = '';

        if (isset($formData['__errors'][$name])) {
            $input .= '<div><input class=\'form-control is-invalid\' type=\''.$type.'\' name=\''.$name.'\' ';
        } else {
            $input .= '<div><input class=\'form-control\' type=\''.$type.'\' name=\''.$name.'\' ';
        }

        if (isset($formData[$name])) {
            $input .= 'value=\''.$formData[$name].'\' ';
        }
        
        if ($placeholder !== NULL) {
            $input .= 'placeholder=\''.$placeholder.'\'';
        } 

        $input .= '></div>';
        
        return $input;
    }

    function getRenderedCheckbox($name, array $formData) 
    {
        $input = '';

        if (isset($formData['__errors'][$name])) {
            $input .= '<div><input class=\'form-check-input checkbox-input is-invalid\' type=\'checkbox\' name="'.$name.'" ';
        } else {
            $input .= '<div><input class=\'form-check-input checkbox-input\' type=\'checkbox\' name="'.$name.'" ';
        }

        if(!empty($formData[$name])) {
            $input .= 'value=\''.$formData[$name].'\' checked';
        } else {
            $input .= 'value=\''.$formData[$name].'\'';
        }

        $input .= '></div>';

        return $input;
    }

    function getRenderedFileInput($name, array $formData, $multiple = FALSE)
    {
        $input = '';

        if (isset($formData['__errors'][$name])) {
            $input .= '<div><input class=\' mt-3 form-control is-invalid\' type=\'file\' ';
        } else {
            $input .= '<div><input class=\'form-control\' type=\'file\' ';
        }

        if($multiple === TRUE) {
            $input .= 'name=\''.$name.'[]\'';
        } else {
            $input .= 'name=\''.$name.'\'';
        }

        if($multiple === FALSE) {
            $input .= ' required>';
        } else if ($multiple === TRUE) {
            $input .= ' multiple>';
        }

        $input .= '</div>';


        return $input;
    }

    function getRenderedTextArea($name, array $formData)
    {
        $textArea = '';

        if (isset($formData['__errors'][$name])) {
            $textArea .= '<div><textarea rows=\'3\' class=\'form-control is-invalid\' name="'.$name.'"></textarea></div>';
        } else {
            $textArea .= '<div><textarea rows=\'3\' class=\'form-control\' name="'.$name.'"></textarea></div>';
        }

        return $textArea;
    }

    function getRenderedTimestampInput($name, array $formData) 
    {
        $input = '<div class=\'\'>';

        if (isset($formData['__errors'][$name])) {
            $input .= '<input class=\'form-control is-invalid\' type=\'date\' name=\''.$name.'[]\'><input class=\'form-control is-invalid mt-2\' type=\'time\' name=\''.$name.'[]\'>';
        } else {
            $input .= '<input class=\'form-control\' type=\'date\' name=\''.$name.'[]\'><input class=\'form-control mt-2\' type=\'time\' name=\''.$name.'[]\'>';
        }

        $input .= '</div>';

        return $input;
    }

    function getRenderedSelect($name, array $formData, array $options)
    {
        $options = getPreparedSelectArray($options);

        $select = '';

        if (isset($formData['__errors'][$name])) {
            $select .= '<div><select class=\'form-select is-invalid\' name=\''.$name.'\'>';
        } else {
            $select .= '<div><select class=\'form-select\' name=\''.$name.'\'>';
        }

        foreach ($options as $valueName => $value) {
            if(isset($formData[$name]) && $formData[$name] == $valueName) {
                $select .= '<option value=\''.$valueName.'\' selected>'.$value.'</option>';
            } else {
                $select .= '<option value=\''.$valueName.'\'>'.$value.'</option>';
            }
        }

        $select .= '</select></div>';
        
        return $select;
    }
    /**
     * Блок окончен
     */



    /**
     * Обработка файлов, при общей обработке формы
     */
    function fileProcessing($field, $fileName, array $extensions, $error, array &$errors, $optional = FALSE, $multiple = FALSE)
    {
        $extensionsString = implode(', ', $extensions);
        if ($error == UPLOAD_ERR_NO_FILE) {
            if ($optional === FALSE) {
                if($multiple === FALSE) {
                    $errors[$field][$fileName] = 'Укажите необходымый файл';
                } else {
                    $errors[$field][$fileName] = 'Укажите необходымые файлы';
                }
            }
        } else if (!in_array(pathinfo($fileName, PATHINFO_EXTENSION), $extensions))
        {
            $errors[$field][$fileName] = 'Укажите файл с изображением в каком-либо из указанных ниже форматов: '.$extensionsString;
        } else if ($error == UPLOAD_ERR_OK) {

        } else if ($error == UPLOAD_ERR_INI_SIZE) {
            $errors[$field][$fileName] = 'Размер данного файла: '.$fileName.' превышает допустимый';
        } else {
            $errors[$field][$fileName] = 'Файл не был отправлен';
        }
    } 

    /**
     * Функция получения корректного времени
     * Вкроятнее всего в ближайшее время будет замещеная с помощью библиотеки Carbon
     */
    function getFormattedTimestamp(string $timestamp) : string
    {
        $date = new \DateTime($timestamp);
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * Функция для формирования get-параметров в ссылке
     */
    function getGETparams(array $existingParamNames, array $newParams = []) : string
    {
        $a = [];
        foreach ($existingParamNames as $name)
        {
            if (!empty($_GET[$name]))
            {
                $a[] = $name.'='.urlencode($_GET[$name]);
            }
        }

        foreach ($newParams as $name => $value)
        {
            $a[] = $name.'='.urlencode($value);
        }
        $s = implode('&', $a);
        if($s)
        {
            $s = '?'.$s;
        }
        return $s;
    }

    /**
     * Функция генерации токена для защиты от CSRF
     */
    function generateToken() : string 
    {
        if(session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
        $token = bin2hex(random_bytes(32));
        $_SESSION[$token] = 'anti_csrf';
        return $token;
    }

    /*
     * Функция проыерки токена
     */
    function checkToken(array $formData)
    {
        if(empty($formData['__token'])) {
            throw new \Modules\Exception\Page403Exception;
        }
        $token = $formData['__token'];
        if(empty($_SESSION[$token])) {
            throw new \Modules\Exception\Page403Exception;
        }
        $value = $_SESSION[$token];
        unset($_SESSION[$token]);
        if($value != 'anti_csrf') {
            throw new \Modules\Exception\Page403Exception;
        }
    }

    function getArrayFromObject(object $object) 
    {
        $array = [];
        foreach($object as $item) {
            $array[] = $item;
        }
        return $array;
    }

}

?>