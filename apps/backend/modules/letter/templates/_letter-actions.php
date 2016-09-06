<div id="admin-nav">
  <ul>
    <li><?= link_to('Редактировать', 'letter_edit', $letter) ?></li>
    <li><?= link_to('Получить код', 'letter/source?id='.$letter->id) ?></li>
  </ul>
</div>

<style type="text/css">
#admin-nav {
  background-color: #EEEEEE;
  border: 1px solid #000000;
  border-right: none;
  border-radius: 5px 0 0 5px;
  -moz-border-radius: 5px 0 0 5px;
  -webkit-border-radius: 5px 0 0 5px;
  font-size: 0.813em;
  position: fixed;
  right: 0;
  top: 200px;
  width: 100px;
  zoom: 1;
}
#admin-nav a {color: #464646; text-decoration: none;}
#admin-nav a:hover {color: #CCCCCC; text-decoration: underline;}
#admin-nav ul {list-style: none; padding-left: 10px;}
#admin-nav li {margin: 5px 0;}
</style>