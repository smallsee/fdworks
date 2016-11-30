
<div ng-controller="BookController">
  <div  class="clearfix" style="width: 600px">
        <div ng-repeat="item in Book.book_data track by $index" style="margin-bottom:10px;width: 200px;height: 300px;float: left; margin-right: 10px;background-color: red">[: $index+1 :]</div>


    <butto ng-click="Book.page=2">第二页</butto>
      <div ng-if="Book.no_more_data">已经没有数据了</div>
      <div ng-if="Book.pending">加载中</div>
    </div>

    <div ng-repeat="page in Book.page_item track by $index">
      {{--ng-style="($index+1)==Book.page ? {backgroundColor:'gray'} : {backgroundColor:'blue'} "--}}
      <button  ng-click="Book.changPage($index+1)" ng-disabled="($index+1)==Book.page">[: $index+1 :]</button>
    </div>

    <div ng-repeat="tag in tags track by $index">
        <div ng-style="tag.tag==Book.tag ? {color:'red'} : {color:'blue'} " ng-click="Book.changTag(tag.tag)">[: tag.name :]</div>
      </div>
</div>




<a ui-sref="book.add">本子添加</a>

<div ui-view></div>