<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity->name ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Main Menu', 'options' => ['class' => 'header']],
                    ['label' => 'Dashboard', 'icon' => 'dashboard', 'url' => ['/site']],
                    ['label' => 'Campus', 'icon' => 'building', 'url' => ['/campus']],
                    [
                        'label' => 'Event',
                        'icon' => 'calendar',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Event List', 'icon' => 'cube', 'url' => ['/event'],],
                            ['label' => 'Main Category', 'icon' => 'th', 'url' => ['/main-category'],],
                            ['label' => 'Category', 'icon' => 'list-ul', 'url' => ['/category'],],
                            ['label' => 'Suggestion', 'icon' => 'bullhorn', 'url' => ['/suggestion'],],
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
