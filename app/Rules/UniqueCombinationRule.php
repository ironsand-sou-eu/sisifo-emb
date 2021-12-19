<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UniqueCombinationRule implements Rule
{
    private $modelName;
    private $fieldnameUnderValidation;
    private $valueUnderValidation;
    private $secondFieldName;
    private $secondFieldValue;

    /**
     * Create a new rule instance.
     *
     * @param string $modelName
     * @param array $secondField, consisting of name and value of the second field
     * @param string $failMsg
     *
     * @return void
     */
    public function __construct($modelName, $secondField)
    {
        $this->modelName = $modelName;
        $this->secondFieldName = $secondField[0];
        $this->secondFieldValue = $secondField[1];
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $this->attribute = $attribute;
        $this->value = $value;
        return $this->modelName::where($attribute, $value)->where($this->secondFieldName, $this->secondFieldValue)->doesntExist();
    }
    
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "Já existe um registro com a coluna {$this->fieldnameUnderValidation} no valor {$$this->valueUnderValidation} ".
                "e a coluna {$this->secondFieldName} no valor {$this->secondFieldValue}.";
    }
}
