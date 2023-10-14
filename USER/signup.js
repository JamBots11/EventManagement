/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/JSP_Servlet/JavaScript.js to edit this template
 */

var app = angular.module('myApp', []);

app.controller('UserController', function($scope) {
    $scope.error1 = "";
    $scope.error2 = "";
    $scope.error3 = "";

    $scope.validateName = function() {
        $scope.error1 = "First character should be capital";
        
        if ($scope.name.length === 0) {
            $scope.error1 = "";
        } else if ($scope.name[0] >= 'A' && $scope.name[0] <= 'Z') {
            var flag = 0;
            for (var i = 0; i < $scope.name.length; i++) {
                if ($scope.name[i] >= '0' && $scope.name[i] <= '9') {
                    $scope.error1 = "";
                    flag = 1;
                } else if (flag === 1) {
                    $scope.error1 = "";
                } else {
                    $scope.error1 = "Username should contain at least one digit";
                }
            }
        } else {
            $scope.error1 = "First character should be capital";
        }
    };

    $scope.validatePassword = function() {
        var specialCharacters = "!@#$%^&*()_+{}[]:;<>,.?~\\/-=";
        $scope.error2 = "";

        if ($scope.password.length === 0) {
            $scope.error2 = "";
        } else {
            var f1 = 0, f2 = 0, f3 = 0;
            for (var i = 0; i < $scope.password.length; i++) {
                if (($scope.password[i] >= 'A' && $scope.password[i] <= 'Z')) {
                    f1 = 1;
                } else if (($scope.password[i] >= 'a' && $scope.password[i] <= 'z')) {
                    f2 = 1;
                } else if (specialCharacters.indexOf($scope.password[i]) !== -1) {
                    f3 = 1;
                } else {
                    $scope.error2 = "";
                }

                if (f1 === 1 && f2 === 1 && f3 === 1) {
                    $scope.error2 = "";
                } else if (f1 === 1 && f3 === 1) {
                    $scope.error2 = "Should contain 1 lowercase";
                } else if (f2 === 1 && f3 === 1) {
                    $scope.error2 = "Should contain 1 uppercase letter";
                } else if (f1 === 1 && f2 === 1) {
                    $scope.error2 = "Should contain 1 special character";
                } else if (f1 === 1) {
                    $scope.error2 = "Should contain 1 lowercase and 1 special";
                } else if (f2 === 1) {
                    $scope.error2 = "Should contain 1 uppercase and 1 special";
                } else if (f3 === 1) {
                    $scope.error2 = "Should contain 1 lowercase and 1 uppercase";
                } else {
                    $scope.error2 = "Should contain 1 uppercase letter, 1 lowercase letter, and 1 special character";
                }
            }
        }
    };

    $scope.validateEmail = function() {
        $scope.error3 = "";

        if ($scope.email === "") {
            $scope.error3 = "";
        } else {
            var pattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]+$/;
            if (pattern.test($scope.email)) {
                $scope.error3 = "";
            } else {
                $scope.error3 = "Enter correct email";
            }
        }
    };

    $scope.redirectToIndex = function() {
        // Replace with the desired URL
        window.location.href = "index.html";
    };

    $scope.redirectToHome = function() {
        // Replace with the desired URL
        window.location.href = "index.html";
    };
});

