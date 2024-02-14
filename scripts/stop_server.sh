#!/bin/bash

if [ "$DEPLOYMENT_GROUP_NAME" == "stg-epay-CodeDeployGroup" ]
then
  # sudo cp -rf /srv/slash_payment/storage /srv
  sudo chmod 777  -R /srv/slash_payment/storage /srv/slash_payment/bootstrap/cache
  sudo chown -R nginx:ec2-user /srv/slash_payment/storage /srv/slash_payment/bootstrap/cache
  # rm -rf /srv/slash_payment
fi

if [ "$DEPLOYMENT_GROUP_NAME" == "prd-epay-CodeDeployGroup" ]
then
  # sudo cp -rf /srv/slash_payment/storage /srv
  sudo chmod 777  -R /srv/slash_payment/storage /srv/slash_payment/bootstrap/cache
  sudo chown -R nginx:ec2-user /srv/slash_payment/storage /srv/slash_payment/bootstrap/cache
  # rm -rf /srv/slash_payment
fi
