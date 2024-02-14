## create infra
- create keypair ec2
- run epay-cloudformation.yaml on aws

## create cicd
- update value parameter store
- run epay-cicd-cloudformation.yaml on aws
- cp server-install.sh and supervisord file to each ec2
- run script server-install.sh on each ec2

## create cloudwatch
https://www.wellarchitectedlabs.com/cost/200_labs/200_aws_resource_optimization/4_memory_plugin/

## create vpc-flow log
- run epay-monitoring.yml on aws