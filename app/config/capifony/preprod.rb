set :domain,      "preprod.#{application}.fr"
#set :domain,      '188.166.72.35'
set :deploy_to,   "/var/www/illicab.fr/preprod"
set :branch, "develop"
role :web, domain
role :app, domain, :primary => true
role :db,  domain, :primary => true
