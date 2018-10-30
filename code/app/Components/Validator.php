<?php

namespace App\Components;

class Validator {

  protected $payload = [];
  protected $schema = [];
  protected $issues = [];
  protected $failing = false;
  
  /**
   * @return $this
   */
  public function setSchema(array $schema) {
    $this->schema = $schema;
    return $this;
  }

  /**
   * @return $this
   */
  public function setPayload(array $payload) {
    $this->payload = $payload;
    return $this;
  }

  private function addIssue(string $field, string $message, bool $fatal = false) {
    $this->issues[$field] = $message;
    if ($fatal) {
      $this->failing = true;
    }
  }

  /**
   * @return $this
   */
  public function evaluate() {
    // Loop through each item in the schema
    foreach ($this->schema as $key => $schemaItems) {
      // Check this item is present in the payload
      if ($payloadValue = array_get($this->payload, $key)) {
        // Loop through each requirement (except required) and evaluate
        foreach(array_except($schemaItems, 'required') as $rule => $value) {
          switch($rule) {
            case 'min':
              if (!(is_string($payloadValue) && strlen($payloadValue) >= $value)) {
                $this->addIssue($key, "Does not meet minimum length of $value", true);
              }
              break;
            case 'max':
              if (!(is_string($payloadValue) && strlen($payloadValue) <= $value)) {
                $this->addIssue($key, "Exceeds maximum length of $value", true);
              }
              break;
            case 'email':
              if (!(preg_match('/.*@.*\..*/', $payloadValue))) {
                $this->addIssue($key, "Is not a valid email address", true);
              }
              break;
            default:
              // Not recognised
              break;
          }
        }
      } else if (array_get($schemaItems, 'required', false) === true) {
        $this->addIssue($key, 'This field is required, but not provided', true);
      }
    }
    return $this;
  }

  /**
   * @return bool|array
   */
  public function getResult() {
    if ($this->failing) {
      return $this->issues;
    }
    return !$this->failing;
  }
}