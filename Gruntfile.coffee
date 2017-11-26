module.exports = (grunt) ->
	grunt.initConfig
		dirs:
			public: 'public'
			assets: 'resources/assets'
			bower: '<%= dirs.assets %>/bower_components'
			script:
				src: '<%= dirs.assets %>/js/coffeescript'
				dest: '<%= dirs.public %>/js'
			coffee:
				src: '<%= dirs.assets %>/js/coffeescript'
				dest: '<%= dirs.script.dest %>'
			style:
				src: '<%= dirs.assets %>/sass'
				dest: '<%= dirs.public %>/css'
			bootstrapSelect:
				base: '<%= dirs.bower %>/bootstrap-select/dist'
				js: '<%= dirs.bootstrapSelect.base %>/js'
				css: '<%= dirs.bootstrapSelect.base %>/css'

		clean:
			css: '<%= dirs.style.dest %>/**/*.css'
			js: '<%= dirs.script.dest %>/**/*.js'

		coffee:
			app:
				expand: true
				flatten: true,
				src: ['<%= dirs.coffee.src %>/*.coffee']
				dest: '<%= dirs.coffee.dest %>/build'
				ext: '.js'

		compass:
			dist:
				options:
					sassDir: '<%= dirs.style.src %>'
					cssDir: '<%= dirs.style.dest %>/compiled'

		concat:
			jsFooter:
				src: [
					'<%= dirs.bootstrapSelect.js %>/bootstrap-select.min.js',
					'<%= dirs.coffee.dest %>/build/*.js'
				],
				dest: '<%= dirs.script.dest %>/reasei.js',
				options:
					separator: ';'

			css:
				src: [
					'<%= dirs.bootstrapSelect.css %>/bootstrap-select.min.css',
					'<%= dirs.style.dest %>/compiled/reasei.css'
				],
				dest: '<%= dirs.style.dest %>/reasei.css',
				options:
					separator: ' '

		uglify:
			jsFooter:
				src: '<%= dirs.script.dest %>/reasei.js'
				dest: '<%= dirs.script.dest %>/reasei.min.js'

		cssmin:
			minify:
				src: '<%= dirs.style.dest %>/reasei.css',
				dest: '<%= dirs.style.dest %>/reasei.min.css'

		watch:
			grunt:
				files: 'gruntfile.*'
				taks: ['build']
			coffee:
				files: '<%= dirs.coffee.src %>/*.coffee'
				tasks: ['script']
			sass:
				files: [
					'<%= dirs.style.src %>/**/*.scss'
				],
				tasks: 'style'

	# Loading neccessary modules
	grunt.loadNpmTasks 'grunt-contrib-clean'
	grunt.loadNpmTasks 'grunt-contrib-copy'
	grunt.loadNpmTasks 'grunt-contrib-compass'
	grunt.loadNpmTasks 'grunt-contrib-concat'
	grunt.loadNpmTasks 'grunt-contrib-uglify'
	grunt.loadNpmTasks 'grunt-contrib-cssmin'
	grunt.loadNpmTasks 'grunt-contrib-coffee'
	grunt.loadNpmTasks 'grunt-contrib-watch'

	# Default task.
	grunt.registerTask 'default', ['build', 'watch']
	grunt.registerTask 'script', ['clean:js', 'coffee', 'concat:jsFooter', 'uglify']
	grunt.registerTask 'style', ['clean:css', 'compass', 'concat:css', 'cssmin']
	grunt.registerTask 'build', ['clean', 'compass', 'coffee', 'concat', 'uglify', 'cssmin']