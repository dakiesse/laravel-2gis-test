<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        @include('includes.docs.api.v1.head')
        <style>
            .rectangle-input[disabled] {
                background: silver;
            }
        </style>
    </head>
    <body>

        <div class="container">
            <div class="row">
                <div class="col-3" id="sidebar">
                    <div class="column-content">
                        <div class="search-header">
                            <img src="/assets/docs/api.v1/img/f2m2_logo.svg" class="logo" alt="Logo" />
                            <input id="search" type="text" placeholder="Search">
                        </div>
                        <ul id="navigation">

                            <li>
                                <a href="#Company">Company</a>
                                <ul>
									<li><a href="#Company_getSearch">getSearch</a></li>

									<li><a href="#Company_getSearchGis">getSearchGis</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#Build">Build</a>
                                <ul>
									<li><a href="#Build_getList">getList</a></li>
</ul>
                            </li>


                        </ul>
                    </div>
                </div>
                <div class="col-9" id="main-content">

                    <div class="column-content">

                        @include('includes.docs.api.v1.introduction')

                        <hr />



                                                <a href="#" class="waypoint" name="Company"></a>
                        <h2>Company</h2>
                        <p></p>


                        <a href="#" class="waypoint" name="Company_getSearch"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>getSearch</h3></li>
                            <li>api/v1/companies/search</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Поиск компаний по различным ее критериями.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc">GET /api/v1/companies/search</p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v1/companies/search" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">ID компании</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">build_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">ID здания в котором необходимо найти компании</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="build_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">category_id</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">ID рубрики в которой необходимо найти компании</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="category_id">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">Имя компании (поиск по шаблону %value%)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="name">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">limit</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">Необходимое кол-во записей (-1 вывести все) (default: 100)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="limit">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">Номер страницы (offset) (default: 1)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="Company_getSearchGis"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>getSearchGis</h3></li>
                            <li>api/v1/companies/search_gis</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Поиск компаний по различным ее критериями.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc">GET /api/v1/companies/search_gis</p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v1/companies/search_gis" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">type</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">Тип полигона/фигуры в котором необходимо найти компании. Возможные значения: circle,
                      rectangle</div>
                                <div class="parameter-value">
                                    <select name="type">
                                        <option value="circle">circle</option>
                                        <option value="rectangle">rectangle</option>
                                    </select>
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">coords[]</div>
                                <div class="parameter-type">array</div>
                                <div class="parameter-desc">Массив координат. Если type - circle: lat и lng центральной точки [2]. Если type -
                      rectangle: lat и lng для верхней левой точки и для нижней правой точки [4].</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="coords[]" value="55.01503224639603">
                                    <input type="text" class="parameter-value-text" name="coords[]" value="82.90145874023439">
                                    <input type="text" class="parameter-value-text rectangle-input" name="coords[]" value="55.06244456743165" disabled>
                                    <input type="text" class="parameter-value-text rectangle-input" name="coords[]" value="82.98900604248048" disabled>
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">radius</div>
                                <div class="parameter-type">float</div>
                                <div class="parameter-desc">Радиус для type - circle</div>
                                <div class="parameter-value">
                                    <input type="number" class="parameter-value-text" name="radius" min="0">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>


                                                <a href="#" class="waypoint" name="Build"></a>
                        <h2>Build</h2>
                        <p></p>


                        <a href="#" class="waypoint" name="Build_getList"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>getList</h3></li>
                            <li>api/v1/buildings/list</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Поиск компаний по различным ее критериями.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc">GET</p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v1/buildings/list" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">limit</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">Необходимое кол-во записей (-1 вывести все) (default: 100)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="limit">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">page</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">Номер страницы (offset) (default: 1)</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="page">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>


                    </div>
                </div>
            </div>
        </div>

        <script>
            $('[name=type]').on('input',function () {
                if(this.value === 'rectangle') {
                    $('.rectangle-input').attr('disabled', false);
                } else {
                    $('.rectangle-input').attr('disabled', true);
                }
            })
        </script>
    </body>
</html>
