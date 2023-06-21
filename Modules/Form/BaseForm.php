<?php

namespace Modules\Form;
class BaseForm 
{
    protected const FIELDS = [];
    
    private static function getInitialValue($fldName, $fldParams, $initial = [])
    {
        if(isset($initial[$fldName])) {
            $val = $initial[$fldName];
        } else if (isset($fldParams['initial'])) {
            $val = $fldParams['initial'];
        } else {
            $val = '';
        }
        return $val;
    }


    protected static function afterInitializeData(&$data) {}
    
    public static function getInitialData($initial = []) 
    {
        $data = [];
        foreach(static::FIELDS as $fldName => $fldParams) {
            $data[$fldName] = self::getInitialValue($fldName, $fldParams, $initial);
        }
        static::afterInitializeData($data);
        return $data;
    }

    protected static function afterNormalizeData(&$data, &$errors) {}

    public static function getNormalizedData($formData)
    {
        $data = [];
        $errors = [];
        foreach(static::FIELDS as $fldName => $fldParams) {
            if (!isset($fldParams['file'])) {
                $fldType = (isset($fldParams['type'])) ? $fldParams['type'] : 'string';
                if($fldType == 'boolean') {
                    $data[$fldName] = isset($formData[$fldName]);
                } else {
                    if(empty($formData[$fldName])) {
                        $data[$fldName] = self::getInitialValue($fldName, $fldParams);
                    
                        if(!isset($fldParams['optional'])) {
                            $errors[$fldName] = 'Это поле обязательно к заполнению';
                        }
                    
                    } else {
                        $fldValue = $formData[$fldName];
                        switch($fldType) {
                            case 'integer':
                                $v = filter_var($fldValue, FILTER_SANITIZE_NUMBER_INT);
                                if($v) {
                                    $data[$fldName] = $v;
                                } else {
                                    $errors[$fldName] = 'Введите целое число';
                                }
                                break;
                            case 'float':
                                $v = filter_var($fldValue, FILTER_SANITIZE_NUMBER_FLOAT, ['flags' => FILTER_FLAG_ALLOW_FRACTION]);
                                if($v) {
                                    $data[$fldName] = $v;
                                } else {
                                    $errors[$fldName] = 'Введите вещественное число';
                                }
                                break;
                            case 'timestamp':
                                if(!empty($fldValue[0]) && !empty($fldValue[1])) {
                                    $fldValue[1] .= ':00';
                                    $data[$fldName] = $fldValue;
                                } else {
                                    $errors[$fldName] = 'Выберите дату и время';
                                }
                                break;
                            case 'email':
                                $v = filter_var($fldValue, FILTER_SANITIZE_EMAIL);
                                if($v) {
                                    $data[$fldName] = $v;
                                } else {
                                    $errors[$fldName] = 'Введите адрес электронной почты';
                                }
                                break;
                            default:
                                $data[$fldName] = filter_var($fldValue, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

                        }
                    }
                }
            } else {
                if(is_array($_FILES[$fldName]['name'])) {
                    if(count($_FILES[$fldName]['name']) <= $fldParams['maxFilesCount']) {
                        foreach ($_FILES[$fldName]['name'] as $index => $name) {
                            $error = $_FILES[$fldName]['error'][$index];
                            \Modules\Helpers\fileProcessing($fldName, $name, $fldParams['extensions'], $error, $errors, $fldParams['optional'], TRUE);
                        }
                    } else {
                        $errors[$fldName] = 'Максимальное количество файлов, которое вы можете отправить - '.$fldParams['maxFilesCount'];
                    }
                } else {
                    $name = $_FILES[$fldName]['name'];
                    $error = $_FILES[$fldName]['error'];
                    \Modules\Helpers\fileProcessing($fldName, $name, $fldParams['extensions'], $error, $errors, $fldParams['optional'], FALSE);
                }
            }
        }
        static::afterNormalizeData($data, $errors);
        if($errors) {
            $data['__errors'] = $errors;
        }
        return $data;
    }


    protected static function afterPrepareData(&$data, &$normData) {}

    public static function getPreparedData($normData)
    {
        $data = [];
        foreach(static::FIELDS as $fldName => $fldParams) {
            if (!isset($fldParams['noSave']) && isset($normData[$fldName])) {
                $val = $normData[$fldName];

                if(isset($fldParams['type']) && $fldParams['type'] == 'timestamp') {
                    $dateTime = new \DateTime(implode(' ', $val));
                    $data[$fldName] = $dateTime->format('Y-m-d H:i:s');
                } else {
                    $data[$fldName] = $val;
                }  
            } 
        }
        static::afterPrepareData($data, $normData);
        return $data;
    }

    /**
     * @param formData нужен лишь для выдачи ошибок при обработке, initial параметры через через этот массив не передаются
     */
    public static function getRenderedForm(array $formData, string $submitButton, $formCssStyle, $formAction = NULL, $selectOptions = NULL, array $formBlocks = NULL, array $openButtons = NULL)
    {
        $mainForm = '';

        $issetFileInputs = FALSE;

        foreach (static::FIELDS as $field => $params) {
            if(isset($params['file']) && $params['file'] == TRUE) {
                $issetFileInputs = TRUE;
                break;
            }
        }

        $mainForm .= '<form class=\''.$formCssStyle.'\'  method=\'post\'';
        
        if($issetFileInputs === TRUE) {
            $mainForm .= ' enctype=\'multipart/form-data\'';
        }

        if(!is_null($formAction)) {
            $mainForm .= ' action=\''.$formAction.'\'';
        }

        $mainForm .= '>';

        if(static::FIELDS !== NULL) {
            foreach (static::FIELDS as $field => $params) {
                if(!isset($params['buttonId']) && !isset($params['blockName'])) {
                    $mainForm .= self::getPreparedInput($field, $params, $formData, $selectOptions);
                } else if (isset($params['buttonId']) && array_key_exists($params['buttonId'], $openButtons)) {
                    $buttonId = NULL;
                    $buttonName = NULL;
                    $blockName = NULL;

                    if(isset($params['buttonId'])) {
                        $buttonId = $params['buttonId'];
                        $buttonName = $openButtons[$buttonId]['buttonName'];
                        $blockName = $openButtons[$buttonId]['blockName'];
                    }

                    $mainForm .= self::getFormBlock($formData, $selectOptions, $blockName, NULL, $buttonId, $buttonName);

                    unset($openButtons[$buttonId]);

                } else if (isset($params['blockName']) && array_key_exists($params['blockName'], $formBlocks)) {
                    $blockId = NULL;
                    $blockName = NULL;

                    if(isset($params['blockName'])) {
                        $blockId = $params['blockName'];
                        $blockName = $formBlocks[$blockId]['blockLabel'];
                    }
                    
                    $mainForm .= self::getFormBlock($formData, $selectOptions, $blockId, $blockName);

                    unset($formBlocks[$blockId]);
                }
            }
        }

        $mainForm .= '<input type=\'hidden\' name=\'__token\' value=\''.$formData['__token'].'\'>';
        $mainForm .= '<div class="d-grid"><button class=\'btn btn-primary mt-3 submit-button\' type=\'submit\' style="font-size: 18px;">'.$submitButton.'</button></form>';

        return $mainForm;
    }

    /**
     * Блок, помогающих рендерингу, методов
     */
    private static function getFormBlock($formData, $selectOptions, $blockName, $blockLabel = NULL, $buttonId = NULL, $buttonName = NULL) 
    {
        $formBlock = '';

        if(!is_null($buttonId)) {
            $formBlock .= '<div class="d-grid"><a class="btn btn-primary mt-4" style="font-size: 20px;" data-bs-toggle="collapse" href="#'.$blockName.'" role="button" aria-expanded="false" aria-controls="'.$blockName.'">'.$buttonName.'</a></div>';
        } else if (!is_null($blockLabel)) {
            $formBlock .= '<div class=\'form-block-label mt-4\' style=\'font-size: 30px;\'>'.$blockLabel.'</div>';
        }

        if(!is_null($buttonId)) {
            $formBlock .= '<div class=\'collapse mt-3\' id=\''.$blockName.'\'>';
        } else {
            $formBlock .= '<div class=\'form-block mt-3\' id=\''.$blockName.'\'>';
        }

        if(!is_null($buttonId)) {
            foreach (static::FIELDS as $fieldName => $fieldParams) {
                if(isset($fieldParams['buttonId']) && $fieldParams['buttonId'] === $buttonId) {
                    $formBlock .= self::getPreparedInput($fieldName, $fieldParams, $formData, $selectOptions);
                }
            }
    
            $formBlock .= '</div>';

        } else if (!is_null($blockLabel)) {
            foreach (static::FIELDS as $fieldName => $fieldParams) {
                if(isset($fieldParams['blockName']) && $fieldParams['blockName'] === $blockName) {
                    $formBlock .= self::getPreparedInput($fieldName, $fieldParams, $formData, $selectOptions);
                }
            }

            $formBlock .= '</div>';
        }

        return $formBlock;
    }

    private static function getPreparedInput(string $field, array $params, $formData, $selectOptions = NULL)
    {
        $preparedInput = '';
        $inputType = NULL;
        $placeholder = NULL;
        $selectOption = NULL;
        if(isset($params['inputType'])) {
            $inputType = $params['inputType'];
        }
        if(isset($params['placeholder'])) {
            $placeholder = $params['placeholder'];
        }
        if($selectOptions !== NULL && isset($selectOptions[$field])) {
            $selectOption = $selectOptions[$field];
        }

        if (isset($params['labelName'])) {
            $preparedInput .= \Modules\Helpers\getRenderedLabel($field, $params['labelName'], $params['fieldType']);
        }

        if (isset($params['file']) && $params['file'] == TRUE) {
            if($params['maxFilesCount'] >= 2) {
                $preparedInput .= \Modules\Helpers\getRenderedFileInput($field, $formData, TRUE);
            } else if ($params['maxFilesCount'] == 1) {
                $preparedInput .= \Modules\Helpers\getRenderedFileInput($field, $formData, FALSE);
            }
        } else {
            $preparedInput .= self::getRightFormOfInput($params['fieldType'], $field, $formData, $inputType, $placeholder, $selectOption);
        }
        
        $preparedInput .= \Modules\Helpers\showErrors($field, $formData);

        return $preparedInput;

    }

    private static function getRightFormOfInput(string $fieldType, string $field, array $formData, string $inputType = NULL, string $placeholder = NULL, array $selectOption = NULL) 
    {
        $input = '';
        switch ($fieldType) {
            case 'input':
                if($inputType !== NULL) {
                    $input .= \Modules\Helpers\getRenderedInput($inputType, $field, $formData, $placeholder);
                }
                break;
            case 'checkbox':
                $input .= \Modules\Helpers\getRenderedCheckbox($field, $formData);
                break;
            case 'textarea':
                $input .= \Modules\Helpers\getRenderedTextArea($field, $formData);
                break;
            case 'select':
                if($selectOption !== NULL) {
                    $input .= \Modules\Helpers\getRenderedSelect($field, $formData, $selectOption);
                }
                break;
            case 'timestamp':
                $input .= \Modules\Helpers\getRenderedTimestampInput($field, $formData);
        }
        return $input;
    }
}

?>