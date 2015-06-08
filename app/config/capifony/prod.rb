set :branch, "master"
#set :domain,      "www.#{application}.fr"
set :domain,      '188.166.72.35'
set :deploy_to,   "/var/www/#{application}/prod"
role :web, domain
role :app, domain, :primary => true
role :db,  domain, :primary => true
