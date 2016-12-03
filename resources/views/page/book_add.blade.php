<div ng-controller="BookAddController">

  <div class="card">


    <form name="BookAdd_form" ng-submit="Book.add()">
      <div class="input-group">
        <label>标题:</label>
        <input name="title" type="text" ng-model="Book.book_data.title" required>
      </div>
      <div ng-if="BookAdd_form.title.$touched" class="input-err-set">
        <div ng-if="BookAdd_form.title.$error.required">标题为必填项</div>
      </div>

      <div class="input-group">
        <input type="checkbox" ng-true-value="true" ng-false-value="false" ng-model="tag.renqi" />人妻
        <input type="checkbox" ng-true-value="true" ng-false-value="false" ng-model="tag.luoli" />萝莉
        <input type="checkbox" ng-true-value="true" ng-false-value="false" ng-model="tag.zhifu" />制服
        <input type="checkbox" ng-true-value="true" ng-false-value="false" ng-model="tag.chinv" />痴女
        <input type="checkbox" ng-true-value="true" ng-false-value="false" ng-model="tag.chushou" />触手
      </div>

      <div class="input-group">
        <label>缩略图:</label>
        <input type="file" name="book_thumb" nv-file-select uploader="uploader" />
        <img ng-src="[: Book.book_data.thumb :]" alt="" width="150px" height="150px">
      </div>
      <button ng-click="look()">查看数据</button>

      <div ng-controller="bookListController">


        <div id="zyupload" class="zyupload"></div>
      </div>

      <textarea ng-model="Book.book_data.content" required></textarea>

      <input type="submit" ng-disabled="BookAdd_form.$invalid || !has_tag || !Book.has_lists"   value="提交">
    </form>



  </div>
</div>

<script type="text/javascript">

</script>