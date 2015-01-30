var Cookie = {
	create: function(name,value,days) {
		var expires;
		if (days) {
			var date = new Date();
			date.setTime(date.getTime()+(days*24*60*60*1000));
			expires = "; expires="+date.toGMTString();
		}
		else expires = "";
		document.cookie = name+"="+value+expires+"; path=/";
	},

	read: function (name) {
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for(var i=0;i < ca.length;i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1,c.length);
			if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
		}
		return null;
	},

	erase: function (name) {
		Cookie.create(name,"",-1);
	}
};

// Article

var Article = {
	init:function(){
		this.bindEvents();

		$(document).ready(function(){
			$('.js-init-gradebar').each(function(){
				Article.initGradeBar($(this));
			});
		});
	},
	bindEvents:function(){
		$('.topic-list').on('click','.article-link',this.postView);
		$('body').on('click','.btn-grade',this.postGrade);
		$('body').on('click','.article-grade',this.reGrade);
	},
	initGradeBar:function($article){
		// run through each article and see if we need a grade bar		
		var article_id = $article.attr('data-article');
		var article_cookie = Cookie.read("ns-article-"+article_id);

		

		if(article_cookie === null){
			// not viewed/graded yet
		}
		else{
			// article cookie is A-F? or 1 for viewed
			var grades = ['A','B','C','D','F'];
			var gradebar = '<div class="btn-group btn-group-grades pull-right">';
			for(var g in grades){
				gradebar+='<button type="button" data-article="'+article_id+'" class="btn-grade btn'+(grades[g] === article_cookie ? ' active':'')+'">'+grades[g]+'</button>';
			}
			gradebar+='</div>';

			if(article_cookie == 1){
				// viewed but not graded
				$article.addClass('article-viewed').removeClass('article-graded');
			}
			else{
				$article.addClass('article-graded').removeClass('article-viewed');
				$article.find('.article-grade').append('<span class="grade-dot grade-'+article_cookie+' my-grade">'+article_cookie+'</span>');
			}
			if(!$article.find('.btn-group-grades').length){
				$article.find('.article-grade').after(gradebar);
			}

		}

	},
	postGrade:function(e) {
		e.preventDefault();
		var $btn = $(this);
		var article_id = $btn.attr('data-article');
		var letter = $btn.text();
		$btn.parent().find('.btn-grade').removeClass('active');
		$btn.addClass('active');

		// add a cookie for the grade
		Cookie.erase("ns-article-"+article_id);
		Cookie.create("ns-article-"+article_id,letter,725);
		Article.initGradeBar($btn.closest('.js-init-gradebar'));
		
		$.post('/api/grade','article_id='+article_id+'&grade='+letter,function(response){

		});
	},
	postView:function(e) {
		var $article = $(this);
		var article_id = $article.attr('data-article');

		// add a cookie registering the article view 
		if(Cookie.read("ns-article-"+article_id) === null){
			Cookie.create("ns-article-"+article_id,"1",725);
			Article.initGradeBar($article);
		}
		$.post('/api/view','article_id='+article_id,function(response){
			
		});
	},
	reGrade:function(e){
		e.preventDefault();
		var $article = $(this).closest('.js-init-gradebar');
		var article_id = $article.attr('data-article');
		$article.find('.my-grade').remove();
		Cookie.erase("ns-article-"+article_id);
		Cookie.create("ns-article-"+article_id,"1",725);

		Article.initGradeBar($article);
	}
};

var Topic = {
	init:function(){
		this.bindEvents();
		$('.topic-name-link').attr('target','_blank').each(function(){
			var $list = $(this).closest('.topic-list');
			var $link = $list.find('.article-link').eq(0);
			$(this).attr('href',$link.attr('href'));
		});
	},
	bindEvents:function(){
		$('body').on('click','.article-dropdown',this.showAll);
		$('body').on('click','.topic-name-link',this.clickTopic);
	},
	clickTopic:function(e){
		var $list = $(this).closest('.topic-list');
		var $link = $list.find('.article-link').eq(0);
		$link.click();

	},
	showAll:function(e) {
		e.preventDefault();
		var $parent = $(this).closest('.panel');
		$parent.toggleClass('show-all');
	}
};

Article.init();
Topic.init();