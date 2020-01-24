all: src/AppBundle/Resources/public/css/main.css

src/AppBundle/Resources/public/css/main.css: src/AppBundle/Resources/public/less/main.less
	lessc src/AppBundle/Resources/public/less/main.less > src/AppBundle/Resources/public/css/main.css
