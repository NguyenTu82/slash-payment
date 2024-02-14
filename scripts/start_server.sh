#!/bin/bash

echo "debug codedeploy" | sudo tee /srv/debugcodedeploy.txt
if [ "$DEPLOYMENT_GROUP_NAME" == "dev-epay-src-pull" ]
then
  echo "dev env" | sudo tee -a /srv/debugcodedeploy.txt
  sudo chown -R ec2-user:ec2-user /srv/slash_payment2
  sudo chown -R nginx:ec2-user /srv/slash_payment2/storage
  sudo chmod -R 775 /srv/slash_payment2/storage
  cd /srv/slash_payment2 | sudo tee -a /srv/debugcodedeploy.txt
  pwd | sudo tee -a /srv/debugcodedeploy.txt
  sudo sh /srv/slash_payment2/deploy.sh | sudo tee -a /srv/debugcodedeploy.txt
  sudo php /srv/slash_payment2/artisan optimize | sudo tee -a /srv/debugcodedeploy.txt
  sudo php /srv/slash_payment2/artisan migrate | sudo tee -a /srv/debugcodedeploy.txt
fi

if [ "$DEPLOYMENT_GROUP_NAME" == "stg-epay-CodeDeployGroup" ]
then
  # sudo cp -rf /srv/storage /srv/slash_payment | sudo tee -a /srv/debugcodedeploy.txt
  sudo chown -R ec2-user:ec2-user /srv/slash_payment | sudo tee -a /srv/debugcodedeploy.txt
  sudo chmod 777  -R /srv/slash_payment/storage /srv/slash_payment/bootstrap/cache | sudo tee -a /srv/debugcodedeploy.txt
  cd /srv/slash_payment | sudo tee -a /srv/debugcodedeploy.txt
  sudo php /srv/slash_payment/artisan optimize | sudo tee -a /srv/debugcodedeploy.txt
  sudo php /srv/slash_payment/artisan view:clear | sudo tee -a /srv/debugcodedeploy.txt
  sudo php /srv/slash_payment/artisan migrate | sudo tee -a /srv/debugcodedeploy.txt
  sudo chown -R nginx:ec2-user /srv/slash_payment/storage
fi

if [ "$DEPLOYMENT_GROUP_NAME" == "prd-epay-CodeDeployGroup" ]
then
  # sudo cp -rf /srv/storage /srv/slash_payment | sudo tee -a /srv/debugcodedeploy.txt
  # shellcheck disable=SC2164
  sudo chown -R ec2-user:ec2-user /srv/slash_payment
  cd /srv/slash_payment
  sudo chown -R nginx:ec2-user /srv/slash_payment/storage
  sudo chmod -R 775 /srv/slash_payment/storage
  sudo php /srv/slash_payment/artisan optimize | sudo tee -a /srv/debugcodedeploy.txt
  sudo php /srv/slash_payment/artisan view:clear | sudo tee -a /srv/debugcodedeploy.txt
  sudo php /srv/slash_payment/artisan migrate | sudo tee -a /srv/debugcodedeploy.txt
  sudo chown -R nginx:ec2-user /srv/slash_payment/storage
fi
