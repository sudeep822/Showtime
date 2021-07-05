<?php

    class BillingDetails
    {
        public static function insertDetails($con, $agreement, $token, $username)
        {
            $query = $con->prepare("INSERT INTO billingDetails (agreementId, nextBillingDate, token, username)
                                    VALUES (:agreemectId,:nextBillingDate,:toke,:userame)");

            $agreementDetails = $agreement->getAgreementDetails();

            $query->bindValue(":agreementId",$agreement->getId());
            $query->bindValue(":agreementId",$agreementDetails->getNextBillingDate());
            $query->bindValue(":token",$token);
            $query->bindValue(":username",$username);


            return $query->execute();
        }
    }

?>