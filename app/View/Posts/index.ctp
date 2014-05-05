<?php 
/**
 * 1. Data Binding and Directives
 * 2. Filters
 * 3. Modules and Contollers
 * 4. Routes
 * 5. Factories
 */

echo $this->Html->css('hoge-animate');

echo $this->Html->script('angular');
echo $this->Html->script('angular-route');
echo $this->Html->script('angular-animate');

?>


<div ng-app="postsApp">
<div ng-view class="hoge"></div>
</div>

<script>
var app = angular.module('postsApp', ['ngRoute', 'ngAnimate']);

app.config(function($routeProvider) {
	$routeProvider.when('/',
	{
		controller: "postsController",
		templateUrl: "<?php echo $this->Html->url('/files/template/posts/list.html'); ?>"
	})
	.when('/view/:postId',
	{
		controller: "PostDetailController",
		templateUrl: "<?php echo $this->Html->url('/files/template/posts/view.html'); ?>"
	})
	.when('/author/:userId',
	{
		controller: "AuthorController",
		templateUrl: "<?php echo $this->Html->url('/files/template/posts/author.html'); ?>"
	});
});
app.controller('postsController', function($scope, postFactory) {
	postFactory.getPosts().success(function(data) {
		$scope.posts = data;
	});
});

app.factory('postFactory', function($http) {
	var factory = {};

	factory.getPosts = function() {
		return $http.get("<?php echo $this->Html->url('page'); ?>");
	};
	factory.getPostDetail = function(postId) {
		return $http.get("<?php echo $this->Html->url('view') ?>/" + postId);
	};
	return factory;
});


app.controller('PostDetailController', function($scope, $routeParams, postFactory) {
	postFactory.getPostDetail($routeParams.postId).success(function(data) {
		$scope.post = data.Post;
	});
});


app.controller('AuthorController', function($scope, $routeParams, authorFactory) {
	authorFactory.getUser($routeParams.userId).success(function(data) {
		$scope.author = data.User;
	});
});

app.factory('authorFactory', function($http) {
	var factory = {};
	factory.getUser = function(userId) {
		return $http.get('<?php echo $this->Html->url('author'); ?>/' + userId);
	};
	return factory;
});


</script>
