module.exports = function (grunt)
{
	grunt.initConfig({

		pkg : grunt.file.readJSON('package.json'),

		uglify :
		{
			app :
			{
				files :
				{
					'inc/assets/js/tms-accordion.min.js' : ['inc/assets/js/tms-accordion.js']
				}
			}
		},

		less :
		{
			app :
			{
				files :
				{
					'inc/assets/css/tms-accordion.css' : 'inc/assets/css/tms-accordion.less'
				}
			}
		},

		cssmin : 
		{	
			app :
			{
				files : 
				{
					'inc/assets/css/tms-accordion.css' : ['inc/assets/css/tms-accordion.css']
				}
			}
		},

		watch :
		{
			options :
			{
				livereload : true,
			},

			scripts :
			{
				files : ['inc/assets/js/tms-accordion.js'],
				tasks : ['uglify:app']
			},

			stylesheets :
			{
				files : ['inc/assets/css/tms-accordion.less'],
				tasks : ['less', 'cssmin']
			},
		}
	});

	grunt.loadNpmTasks('grunt-contrib-less');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-uglify');

	grunt.registerTask('default', ['less', 'cssmin', 'uglify']);
};