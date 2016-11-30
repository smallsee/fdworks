
<div ng-controller="BookController">
  <div  class="clearfix" style="width: 500px">
        <div ng-repeat="item in Book.book_data track by $index" style="margin-bottom:10px;width: 200px;height: 300px;float: left; margin-right: 10px;background-color: red"></div>


    <butto ng-click="Book.page=2">第二页</butto>
      <div ng-if="Book.no_more_data">已经没有数据了</div>
    </div>
</div>




<a ui-sref="book.add">本子添加</a>

<div ui-view></div>