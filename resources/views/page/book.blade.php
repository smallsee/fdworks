
<div ng-controller="BookController">


  <div id="book-mainBox" class="clearfix">

    <div class="book-box box-clone clearfix">
      <div class="book-pic clearfix" style="width: 232px; opacity: 1">
        <a href="#"><div class="book-newPost">发新帖</div></a>
        <div class="book-category clearfix">
          <div>分类:</div>
          <div ng-repeat="tag in tags track by $index"
               class="book-category-icon category-tab"
               ng-class="{true: 'active', false: 'inactive'}[tag.tag==Book.tag]"
               ng-click="Book.changTag(tag.tag)"
          >[: tag.name :]</div>

        </div>
        <div class="book-category clearfix" style="height: 30px;">
          <div>筛选:</div>
          <div class="book-category-icon active">全部</div>
          <div class="book-category-icon">人气</div>
          <div class="book-category-icon">精华</div>
        </div>

        <div class="book-category clearfix" style="height: 110px;">
          <div>排序:</div>
          <div class="book-category-icon active">按发表时间</div>
          <div class="book-category-icon">按回复时间</div>
          <div class="book-category-icon">按查看次数</div>
          <div class="book-category-icon">按回复次数</div>
          <div class="book-category-icon">随机</div>
        </div>
      </div>
    </div>



    <div ng-repeat="item in Book.book_data track by $index" class="book-box" repeat-finish>

      <div class="book-pic">
        <img ng-src="[: item.thumb :]" alt="">
        <div class="book-title" ng-bind="item.title"></div>
        <div class="book-content" ng-bind="item.content"></div>
        <div class="book-icon clearfix">
          <div class="icon-eye-open">查看</div>
          <div class="icon-comments-alt">评论</div>
        </div>
        <div class="book-username">
          <img ng-src="[: item.user.avatar :]" alt="">
          <div ng-bind="item.user.nickname"></div>
        </div>
      </div>
    </div>

    <div  style="position: absolute;bottom: 5px;right: 5px;">

        <button  ng-repeat="page in Book.page_item track by $index" style="float: left"  ng-click="Book.changPage($index+1)" ng-disabled="($index+1)==Book.page">[: $index+1 :]</button>

      <div style="position: absolute;bottom: 5px;right: 500px;width: 200px;" ng-if="Book.no_more_data">已经没有数据了</div>
      <div style="position: absolute;bottom: 5px;right: 500px;width: 200px;" ng-if="Book.pending">加载中</div>
    </div>
  </div>



  {{--获取数据基础数据--}}
  {{--<div  class="clearfix" style="width: 600px">--}}
        {{--<div ng-repeat="item in Book.book_data track by $index" style="margin-bottom:10px;width: 200px;height: 300px;float: left; margin-right: 10px;background-color: red">[: $index+1 :]</div>--}}
    {{--<butto ng-click="Book.page=2">第二页</butto>--}}
      {{--<div ng-if="Book.no_more_data">已经没有数据了</div>--}}
      {{--<div ng-if="Book.pending">加载中</div>--}}
  {{--</div>--}}


    {{--<div ng-repeat="tag in tags track by $index">--}}
        {{--<div ng-style="tag.tag==Book.tag ? {color:'red'} : {color:'blue'} " ng-click="Book.changTag(tag.tag)">[: tag.name :]</div>--}}
    {{--</div>--}}
</div>




<a ui-sref="book.add">本子添加</a>

<div ui-view></div>