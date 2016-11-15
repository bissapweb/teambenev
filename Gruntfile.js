module.exports = function(grunt) {
  require('jit-grunt')(grunt);

  grunt.initConfig({
    less: {
      development: {
        options: {
          compress: true,
          yuicompress: true,
          optimization: 2
        },
        files: {
          "web/assets/vendor/bootstrap/main_v1.css": "web/assets/vendor/bootstrap/less/bootstrap.less" // destination file and source file
        }
      }
    },
    watch: {
      styles: {
        files: ['web/assets/vendor/bootstrap/less/**/*.less'], // which files to watch
        tasks: ['less'],
        options: {
          nospawn: true
        }
      }
    }
  });

  grunt.registerTask('default', ['less', 'watch']);
};

