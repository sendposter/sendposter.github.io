
!function(t,e){t(".bpw_IsFlip").flip(),t(document).on("click",".bpw_btn-continue",function(e){e.preventDefault();var n=t(this).closest(".bpw_quizCtr"),a=parseInt(n.data("current-question")),i=n.data("transition_in"),s=n.data("transition_out"),r=n.find(".bpw_questionsCtr > .bpw_singleQuestionWrapper").eq(a),o=parseInt(n.data("questions")),d=parseInt(n.data("questions-answered")),l=parseInt(d/o*100);parseInt(n.data("quiz-timer"));r.next().length&&(r.transition({animation:s,onComplete:function(){r.hide(),r.next().transition({animation:i}),n.data("current-question",a+1)}}),n.find(".bpw_quizProgressValue").animate({width:l+"%"}).text(l+"%"),t("html, body").animate({scrollTop:n.offset().top-35},750))}),t(document).on("click",".bpw_shareFB",function(e){e.preventDefault();var n=t(this).closest(".bpw_quizCtr"),a=n.data("share-url"),i=n.find(".bpw_singleResultWrapper:visible"),s=i.find(".bpw_resultDesc").text(),r=i.find(".bpw_resultImg").attr("src"),o=n.data("featured-image"),d=n.data("excerpt");if(i.hasClass("bpw_IsTrivia"))var l=parseInt(n.data("correct-answered")),u=parseInt(n.data("questions")),w=bpw_l10n.captionTriviaFB.replace("%%score%%",l).replace("%%total%%",u);else if(i.hasClass("bpw_IsPersonality"))var w=i.find(".bpw_resultTitle").data("title");else var w=n.data("post-title");FB.ui({method:"feed",link:a,name:w,description:s?s:d,picture:r?r:o},function(t){})}),t(document).on("click",".bpw_shareTwitter",function(e){e.preventDefault();var n=t(this).closest(".bpw_quizCtr"),a=n.data("share-url"),i=n.find(".bpw_singleResultWrapper:visible");if(i.hasClass("bpw_IsTrivia"))var s=parseInt(n.data("correct-answered")),r=parseInt(n.data("questions")),o=bpw_l10n.captionTriviaFB.replace("%%score%%",s).replace("%%total%%",r);else if(i.hasClass("bpw_IsPersonality"))var o=i.find(".bpw_resultTitle").data("title");else var o=n.data("post-title");window.open("https://twitter.com/share?url="+a+"&text="+encodeURI(o),"_blank","width=500, height=300")}),t(document).on("click",".bpw_shareGP",function(e){e.preventDefault();var n=t(this).closest(".bpw_quizCtr"),a=n.data("share-url");window.open("https://plus.google.com/share?url="+a,"_blank","width=500, height=300")}),t(document).on("click",".bpw_shareVK",function(e){e.preventDefault();var n=t(this).closest(".bpw_quizCtr"),a=n.data("share-url");window.open("http://vk.com/share.php?url="+a,"_blank","width=500, height=300")}),t(document).on("click",".bpw_retakeQuizBtn",function(e){e.preventDefault(),console.log("Retake start!");var n=t(this).closest(".bpw_quizCtr"),a=n.data("transition_in"),i=n.data("transition_out"),s=n.data("question-layout");n.data("current-question",0),n.data("questions-answered",0),n.data("correct-answered",0),n.find(".bpw_quizProgressValue").animate({width:"0%"}).text(""),n.find(".bpw_questionsCtr > .bpw_singleQuestionWrapper").each(function(){t(this).find(".bpw_triviaQuestionExplanation").removeClass("transition visible"),t(this).find(".bpw_triviaQuestionExplanation").hide(),t(this).find(".bpw_singleAnswerCtr").removeClass("bpw_incorrectAnswer bpw_correctAnswer chosen bpw_answerSelected"),t(this).find(".bpw_ExplanationHead").removeClass("bpw_correctExplanationHead bpw_wrongExplanationHead"),t(this).data("question-answered",1),t(this).removeClass("bpw_questionAnswered")}),n.find(".bpw_singleResultWrapper, .bpw_singleResultRow").data("points",0),n.find(".bpw_questionsCtr").show(),n.find(".bpw_singleResultWrapper.transition.visible").transition({animation:i,onComplete:function(){n.find(".bpw_singleResultWrapper").hide(),"multiple"==s&&n.find(".bpw_questionsCtr > .bpw_singleQuestionWrapper:last").transition({animation:i,onComplete:function(){n.find(".bpw_questionsCtr > .bpw_singleQuestionWrapper:eq(0)").transition({animation:a})}}),n.find(".bpw_singleResultWrapper, .bpw_resultsTable, .bpw_shareResultCtr, .bpw_resultsCtr, .bpw_quizEmailCtr, .bpw_quizForceShareCtr, .bpw_retakeQuizBtn, .bpw_retakeQuizCtr").removeClass("transition hidden visible"),n.find(".bpw_resultExplanation, .bpw_quizEmailCtr, .bpw_quizForceShareCtr, .bpw_retakeQuizBtn").hide()}}),t("html, body").animate({scrollTop:n.offset().top-35},750),t(this).removeClass("transition visible").hide()}),t(document).ready(function(){function e(e){t(".bpw_IsFlip .back").each(function(){var n=t(this).find("img").attr("src"),a=t(this).siblings(".item_top").height();if(t(this).css("top",a+"px"),""==n){var i=this;if(t(this).siblings(".front").find("img").on("load",function(){t(i).find(".desc").height(t(this).height())}),"resize"==e.type){var s=t(this).siblings(".front").find("img").height();t(this).find(".desc").height(s)}}})}t(window).on("resize",e),t(document).on("ready",e),t(window).trigger("resize")})}(jQuery,window),function(t,e){function n(e,n){var a=e.data("transition_in"),i=(e.data("transition_out"),parseInt(e.data("correct-answered"))),s=parseInt(e.data("questions")),r=(parseInt(e.data("display-answers")),parseInt(e.data("quiz-pid")),e.data("ajax-url"),parseInt(e.data("retake-quiz")));e.find(".bpw_continue").hide();var o=!1;e.find(".bpw_singleResultWrapper").each(function(){var e=parseInt(t(this).data("min")),n=parseInt(t(this).data("max"));if(i>=e&&n>=i&&!o){o=!0;var r=bpw_l10n.captionTrivia.replace("%%score%%",i).replace("%%total%%",s);return t(this).find(".bpw_resultScoreCtr").text(r),void t(this).transition({animation:a})}}),r&&e.find(".bpw_retakeQuizBtn").transition({animation:a})}t(document).on("click",".bpw_singleQuestionWrapper:not(.bpw_questionAnswered) .bpw_singleAnswerCtr.bpw_IsTrivia",function(e){e.preventDefault();var a=parseInt(t(this).data("crt")),i=t(this).closest(".bpw_singleQuestionWrapper"),s=t(this).closest(".bpw_quizCtr"),r=(s.data("transition_in"),s.data("transition_out"),parseInt(s.data("questions"))),o=parseInt(s.data("questions-answered"))+1,d=(parseInt(o/r*100),parseInt(s.data("correct-answered"))),l=parseInt(s.data("current-question")),u=t(".bpw_questionsCtr > .bpw_singleQuestionWrapper").eq(l),w=(parseInt(s.data("quiz-timer")),s.data("question-layout")),q=parseInt(s.data("auto-scroll"));if(i.addClass("bpw_questionAnswered"),1===a?(t(this).addClass("bpw_correctAnswer chosen"),i.find(".bpw_triviaQuestionExplanation .bpw_ExplanationHead").text(bpw_l10n.correct).addClass("bpw_correctExplanationHead"),d++,s.data("correct-answered",d)):(i.find(".bpw_singleAnswerCtr").each(function(){1==t(this).data("crt")&&t(this).addClass("bpw_correctAnswer")}),t(this).addClass("bpw_incorrectAnswer chosen"),i.find(".bpw_triviaQuestionExplanation .bpw_ExplanationHead").text(bpw_l10n.wrong).addClass("bpw_wrongExplanationHead")),"single"==w){var l=parseInt(s.data("current-question"));s.data("current-question",l+1)}else i.find(".bpw_continue").show();return s.data("questions-answered",o),i.find(".bpw_triviaQuestionExplanation").show(),1===q&&t("html, body").animate({scrollTop:i.find(".bpw_triviaQuestionExplanation").offset().top-35},750),r===o?(s.find(".bpw_quizProgressValue").animate({width:"100%"}).text("100%"),void n(s,u)):void 0})}(jQuery,window),function(t,e){t(document).on("click",".bpw_singleQuestionWrapper:not(.bpw_questionAnswered) .bpw_singleAnswerCtr.bpw_IsPersonality",function(e){e.preventDefault();var n=t(this).closest(".bpw_quizCtr"),a=JSON.parse(t(this).find(".bpw_singleAnswerResultCtr").val()),i=t(this).closest(".bpw_singleQuestionWrapper"),s=parseInt(i.data("question-answered")),r=parseInt(n.data("questions-answered")),o=parseInt(n.data("questions")),d=n.data("transition_in"),l=(n.data("transition_out"),parseInt(n.data("quiz-pid")),parseInt(n.data("retake-quiz"))),u=n.data("question-layout"),w=(n.data("ajax-url"),parseInt(n.data("auto-scroll")));if(i.addClass("bpw_questionAnswered"),i.find(".bpw_singleAnswerCtr.bpw_answerSelected").each(function(){var e=JSON.parse(t(this).find(".bpw_singleAnswerResultCtr").val());""!==e&&e.forEach(function(t,e,a){var i=n.find('.bpw_singleResultWrapper[data-rid="'+e+'"]'),s=parseInt(i.data("points"))-parseInt(t.points);i.data("points",s)})}),""!==a&&a.forEach(function(t,e,a){var i=n.find('.bpw_singleResultWrapper[data-rid="'+e+'"]'),s=parseInt(i.data("points"))+parseInt(t.points);i.data("points",s)}),1===s&&(r++,i.data("question-answered",2),n.data("questions-answered",r)),t(this).addClass("bpw_answerSelected"),"single"==u){var q=parseInt(n.data("current-question"));n.data("current-question",q+1),i.next().length&&1===w&&t("html, body").animate({scrollTop:i.next().offset().top-75},750)}else i.find(".bpw_btn-continue").trigger("click");if(o===r){n.find(".bpw_quizProgressValue").animate({width:"100%"}).text("100%"),t("html, body").animate({scrollTop:n.find(".bpw_resultsCtr").offset().top-75},750);var c=null,p=0;n.find(".bpw_singleResultWrapper").each(function(){var e=parseInt(t(this).data("points"));e>p&&(p=e,c=this)});var _=t(c).find(".bpw_resultTitle").data("title");t(c).find(".bpw_resultTitle").text(_),t(c).transition({animation:d}),l&&n.find(".bpw_retakeQuizBtn").transition({animation:d})}})}(jQuery,window);