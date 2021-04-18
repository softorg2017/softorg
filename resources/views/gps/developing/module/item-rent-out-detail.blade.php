{{--house-detail--}}
<div class="module-container" id="property-single">
    <div class="container main-container">

        <div class="col-lg-12 col-md-12 ">

            {{----}}
            @include('frontend.module.section-header-info', ['data'=>$data])

            {{----}}
            @include('frontend.module.section-information', ['data'=>$data])

            {{--最新动态--}}
            {{--@include('frontend.module.section-recent-news', ['data'=>$data])--}}

            {{--图片展示--}}
            @include('frontend.module.section-images', ['data'=>$data])

            {{--图文详情--}}
            @include('frontend.module.section-detail', ['data'=>$data,'title_is'=>0])

            {{--视频展示--}}
            {{--@include('frontend.module.section-video')--}}

            {{--地图--}}
            {{--@include('frontend.module.section-map')--}}

            {{--经纪人--}}
            {{--@include('frontend.module.section-agent')--}}

            @include('frontend.module.section-rent-out', ['items'=>$items])

        </div>

        <div class="col-lg-12 col-md-12 _none">

            {{----}}
            <section class="property-single-features common clearfix _none-">
                <h4 class="entry-title">Property Features</h4>
                <ul class="property-single-features-list clearfix">
                    <li>Air Conditioning</li>
                    <li>Cable TV</li>
                    <li>Cot</li>
                    <li class="disabled">Fan</li>
                    <li>Lift</li>
                    <li>Parking</li>
                    <li>Separate Shower</li>
                    <li>Office/den</li>
                    <li class="disabled">Air Conditioning</li>
                    <li>Cable TV</li>
                    <li>Cot</li>
                    <li>Fan</li>
                    <li>Lift</li>
                    <li class="disabled">Parking</li>
                    <li>Cot</li>
                    <li>Fan</li>
                    <li>Lift</li>
                    <li>Parking</li>
                    <li>Separate Shower</li>
                    <li class="disabled">Office/den</li>
                    <li>Air Conditioning</li>
                    <li>Cable TV</li>
                </ul>
            </section>

        </div>



        {{--图片--}}
        <div class="col-lg-12 col-md-12 _none">
            <img src="{{ url('/custom/images/box-img.jpg') }}" alt="" />
        </div>


        {{--其他楼盘--}}
        <div class="col-lg-12 col-md-12 _none">
            <div id="property-sidebar">


                {{----}}
                <section class="widget adv-search-widget clearfix _none-">
                    <h5 class="title hide">Search your Place</h5>
                    <div id="advance-search-widget" class="clearfix">
                        <form action="single-property.html#" id="adv-search-form">
                            <div id="widget-tabs">
                                <ul class="tab-list clearfix">
                                    <li><a class="btn" href="single-property.html#tab-1">Sale</a></li>
                                    <li><a class="btn" href="single-property.html#tab-2">Rent</a></li>
                                    <li><a class="btn" href="single-property.html#tab-3">office for rent</a></li>
                                </ul>
                                <div id="tab-1" class="tab-content current">
                                    <fieldset class="clearfix">
                                        <div>
                                            <label for="main-location">All Location</label>
                                            <select name="location" id="main-location">
                                                <option value="">All Cities</option>
                                                <option value="chicago"> Chicago</option>
                                                <option value="los-angeles"> Los Angeles</option>
                                                <option value="miami"> Miami</option>
                                                <option value="new-york"> New York</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="property-sub-location">Sub Location</label>
                                            <select name="sub-location" id="property-sub-location">
                                                <option value="">All Areas</option>
                                                <option value="brickell" > Brickell</option>
                                                <option value="brickyard" > Brickyard</option>
                                                <option value="bronx" > Bronx</option>
                                                <option value="brooklyn" > Brooklyn</option>
                                                <option value="coconut-grove" > Coconut Grove</option>
                                                <option value="downtown" > Downtown</option>
                                                <option value="eagle-rock" > Eagle Rock</option>
                                                <option value="englewood" > Englewood</option>
                                                <option value="hermosa" > Hermosa</option>
                                                <option value="hollywood" > Hollywood </option>
                                                <option value="lincoln-park" > Lincoln Park</option>
                                                <option value="manhattan" > Manhattan</option>
                                                <option value="midtown" > Midtown</option>
                                                <option value="queens" > Queens</option>
                                                <option value="westwood" > Westwood </option>
                                                <option value="wynwood" > Wynwood</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="property-status">All Status</label>
                                            <select id="property-status" name="status">
                                                <option value="">All Status</option>
                                                <option value="for-rent"> For Rent</option>
                                                <option value="for-sale"> For Sale</option>
                                                <option value="foreclosures"> Foreclosures</option>
                                                <option value="new-costruction"> New Costruction</option>
                                                <option value="new-listing"> New Listing</option>
                                                <option value="open-house"> Open House</option>
                                                <option value="reduced-price"> Reduced Price</option>
                                                <option value="resale"> Resale</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="property-type">All Types</label>
                                            <select id="property-type" name="type" >
                                                <option value="">All Types</option>
                                                <option value="apartment"> Apartment</option>
                                                <option value="condo"> Condo</option>
                                                <option value="farm"> Farm</option>
                                                <option value="loft"> Loft</option>
                                                <option value="lot"> Lot</option>
                                                <option value="multi-family-home"> Multi Family Home</option>
                                                <option value="single-family-home"> Single Family Home</option>
                                                <option value="townhouse"> Townhouse</option>
                                                <option value="villa"> Villa</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="property-beds">No.Beds</label>
                                            <select name="bedrooms" id="property-beds">
                                                <option value="">Beds</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="any">Any</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="property-baths">No.Baths</label>
                                            <select name="bathrooms" id="property-baths">
                                                <option value="">Bathrooms</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="any">Any</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="property-min-area">Min Area(sqft)</label>
                                            <input type="text" name="min-area" id="property-min-area">
                                        </div>
                                        <div>
                                            <label for="property-max-area">Max Area(sqft)</label>
                                            <input type="text" name="max-area" id="property-max-area">
                                        </div>
                                        <div>
                                            <label for="property-min-price">Min Prices</label>
                                            <select name="min-price" id="property-min-price">
                                                <option value="any" selected="selected">Any</option>
                                                <option value="1000">$1000</option>
                                                <option value="5000">$5000</option>
                                                <option value="10000">$10000</option>
                                                <option value="50000">$50000</option>
                                                <option value="100000">$100000</option>
                                                <option value="200000">$200000</option>
                                                <option value="300000">$300000</option>
                                                <option value="400000">$400000</option>
                                                <option value="500000">$500000</option>
                                                <option value="600000">$600000</option>
                                                <option value="700000">$700000</option>
                                                <option value="800000">$800000</option>
                                                <option value="900000">$900000</option>
                                                <option value="1000000">$1000000</option>
                                                <option value="1500000">$1500000</option>
                                                <option value="2000000">$2000000</option>
                                                <option value="2500000">$2500000</option>
                                                <option value="5000000">$5000000</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="property-max-price">Max Prices</label>
                                            <select name="max-price" id="property-max-price" >
                                                <option value="any" selected="selected">Any</option>
                                                <option value="5000">$5000</option>
                                                <option value="10000">$10000</option>
                                                <option value="50000">$50000</option>
                                                <option value="100000">$100000</option>
                                                <option value="200000">$200000</option>
                                                <option value="300000">$300000</option>
                                                <option value="400000">$400000</option>
                                                <option value="500000">$500000</option>
                                                <option value="600000">$600000</option>
                                                <option value="700000">$700000</option>
                                                <option value="800000">$800000</option>
                                                <option value="900000">$900000</option>
                                                <option value="1000000">$1000000</option>
                                                <option value="1500000">$1500000</option>
                                                <option value="2000000">$2000000</option>
                                                <option value="2500000">$2500000</option>
                                                <option value="5000000">$5000000</option>
                                                <option value="10000000">$10000000</option>
                                            </select>
                                        </div>
                                    </fieldset>
                                </div>
                                <div id="tab-2" class="tab-content">
                                    <fieldset class="clearfix">
                                        <div>
                                            <label for="main-location">All Location</label>
                                            <select name="location" id="main-location">
                                                <option value="">All Cities</option>
                                                <option value="chicago"> Chicago</option>
                                                <option value="los-angeles"> Los Angeles</option>
                                                <option value="miami"> Miami</option>
                                                <option value="new-york"> New York</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="property-sub-location">Sub Location</label>
                                            <select name="sub-location" id="property-sub-location">
                                                <option value="">All Areas</option>
                                                <option value="brickell" > Brickell</option>
                                                <option value="brickyard" > Brickyard</option>
                                                <option value="bronx" > Bronx</option>
                                                <option value="brooklyn" > Brooklyn</option>
                                                <option value="coconut-grove" > Coconut Grove</option>
                                                <option value="downtown" > Downtown</option>
                                                <option value="eagle-rock" > Eagle Rock</option>
                                                <option value="englewood" > Englewood</option>
                                                <option value="hermosa" > Hermosa</option>
                                                <option value="hollywood" > Hollywood </option>
                                                <option value="lincoln-park" > Lincoln Park</option>
                                                <option value="manhattan" > Manhattan</option>
                                                <option value="midtown" > Midtown</option>
                                                <option value="queens" > Queens</option>
                                                <option value="westwood" > Westwood </option>
                                                <option value="wynwood" > Wynwood</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="property-status">All Status</label>
                                            <select id="property-status" name="status">
                                                <option value="">All Status</option>
                                                <option value="for-rent"> For Rent</option>
                                                <option value="for-sale"> For Sale</option>
                                                <option value="foreclosures"> Foreclosures</option>
                                                <option value="new-costruction"> New Costruction</option>
                                                <option value="new-listing"> New Listing</option>
                                                <option value="open-house"> Open House</option>
                                                <option value="reduced-price"> Reduced Price</option>
                                                <option value="resale"> Resale</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="property-type">All Types</label>
                                            <select id="property-type" name="type" >
                                                <option value="">All Types</option>
                                                <option value="apartment"> Apartment</option>
                                                <option value="condo"> Condo</option>
                                                <option value="farm"> Farm</option>
                                                <option value="loft"> Loft</option>
                                                <option value="lot"> Lot</option>
                                                <option value="multi-family-home"> Multi Family Home</option>
                                                <option value="single-family-home"> Single Family Home</option>
                                                <option value="townhouse"> Townhouse</option>
                                                <option value="villa"> Villa</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="property-beds">No.Beds</label>
                                            <select name="bedrooms" id="property-beds">
                                                <option value="">Beds</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="any">Any</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="property-baths">No.Baths</label>
                                            <select name="bathrooms" id="property-baths">
                                                <option value="">Bathrooms</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="any">Any</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="property-min-area">Min Area(sqft)</label>
                                            <input type="text" name="min-area" id="property-min-area">
                                        </div>
                                        <div>
                                            <label for="property-max-area">Max Area(sqft)</label>
                                            <input type="text" name="max-area" id="property-max-area">
                                        </div>
                                        <div>
                                            <label for="property-min-price">Min Prices</label>
                                            <select name="min-price" id="property-min-price">
                                                <option value="any" selected="selected">Any</option>
                                                <option value="1000">$1000</option>
                                                <option value="5000">$5000</option>
                                                <option value="10000">$10000</option>
                                                <option value="50000">$50000</option>
                                                <option value="100000">$100000</option>
                                                <option value="200000">$200000</option>
                                                <option value="300000">$300000</option>
                                                <option value="400000">$400000</option>
                                                <option value="500000">$500000</option>
                                                <option value="600000">$600000</option>
                                                <option value="700000">$700000</option>
                                                <option value="800000">$800000</option>
                                                <option value="900000">$900000</option>
                                                <option value="1000000">$1000000</option>
                                                <option value="1500000">$1500000</option>
                                                <option value="2000000">$2000000</option>
                                                <option value="2500000">$2500000</option>
                                                <option value="5000000">$5000000</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="property-max-price">Max Prices</label>
                                            <select name="max-price" id="property-max-price" >
                                                <option value="any" selected="selected">Any</option>
                                                <option value="5000">$5000</option>
                                                <option value="10000">$10000</option>
                                                <option value="50000">$50000</option>
                                                <option value="100000">$100000</option>
                                                <option value="200000">$200000</option>
                                                <option value="300000">$300000</option>
                                                <option value="400000">$400000</option>
                                                <option value="500000">$500000</option>
                                                <option value="600000">$600000</option>
                                                <option value="700000">$700000</option>
                                                <option value="800000">$800000</option>
                                                <option value="900000">$900000</option>
                                                <option value="1000000">$1000000</option>
                                                <option value="1500000">$1500000</option>
                                                <option value="2000000">$2000000</option>
                                                <option value="2500000">$2500000</option>
                                                <option value="5000000">$5000000</option>
                                                <option value="10000000">$10000000</option>
                                            </select>
                                        </div>
                                    </fieldset>
                                </div>
                                <div id="tab-3" class="tab-content">
                                    <fieldset class="clearfix">
                                        <div>
                                            <label for="main-location">All Location</label>
                                            <select name="location" id="main-location">
                                                <option value="">All Cities</option>
                                                <option value="chicago"> Chicago</option>
                                                <option value="los-angeles"> Los Angeles</option>
                                                <option value="miami"> Miami</option>
                                                <option value="new-york"> New York</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="property-sub-location">Sub Location</label>
                                            <select name="sub-location" id="property-sub-location">
                                                <option value="">All Areas</option>
                                                <option value="brickell" > Brickell</option>
                                                <option value="brickyard" > Brickyard</option>
                                                <option value="bronx" > Bronx</option>
                                                <option value="brooklyn" > Brooklyn</option>
                                                <option value="coconut-grove" > Coconut Grove</option>
                                                <option value="downtown" > Downtown</option>
                                                <option value="eagle-rock" > Eagle Rock</option>
                                                <option value="englewood" > Englewood</option>
                                                <option value="hermosa" > Hermosa</option>
                                                <option value="hollywood" > Hollywood </option>
                                                <option value="lincoln-park" > Lincoln Park</option>
                                                <option value="manhattan" > Manhattan</option>
                                                <option value="midtown" > Midtown</option>
                                                <option value="queens" > Queens</option>
                                                <option value="westwood" > Westwood </option>
                                                <option value="wynwood" > Wynwood</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="property-status">All Status</label>
                                            <select id="property-status" name="status">
                                                <option value="">All Status</option>
                                                <option value="for-rent"> For Rent</option>
                                                <option value="for-sale"> For Sale</option>
                                                <option value="foreclosures"> Foreclosures</option>
                                                <option value="new-costruction"> New Costruction</option>
                                                <option value="new-listing"> New Listing</option>
                                                <option value="open-house"> Open House</option>
                                                <option value="reduced-price"> Reduced Price</option>
                                                <option value="resale"> Resale</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="property-type">All Types</label>
                                            <select id="property-type" name="type" >
                                                <option value="">All Types</option>
                                                <option value="apartment"> Apartment</option>
                                                <option value="condo"> Condo</option>
                                                <option value="farm"> Farm</option>
                                                <option value="loft"> Loft</option>
                                                <option value="lot"> Lot</option>
                                                <option value="multi-family-home"> Multi Family Home</option>
                                                <option value="single-family-home"> Single Family Home</option>
                                                <option value="townhouse"> Townhouse</option>
                                                <option value="villa"> Villa</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="property-beds">No.Beds</label>
                                            <select name="bedrooms" id="property-beds">
                                                <option value="">Beds</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="any">Any</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="property-baths">No.Baths</label>
                                            <select name="bathrooms" id="property-baths">
                                                <option value="">Bathrooms</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                                <option value="any">Any</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="property-min-area">Min Area(sqft)</label>
                                            <input type="text" name="min-area" id="property-min-area">
                                        </div>
                                        <div>
                                            <label for="property-max-area">Max Area(sqft)</label>
                                            <input type="text" name="max-area" id="property-max-area">
                                        </div>
                                        <div>
                                            <label for="property-min-price">Min Prices</label>
                                            <select name="min-price" id="property-min-price">
                                                <option value="any" selected="selected">Any</option>
                                                <option value="1000">$1000</option>
                                                <option value="5000">$5000</option>
                                                <option value="10000">$10000</option>
                                                <option value="50000">$50000</option>
                                                <option value="100000">$100000</option>
                                                <option value="200000">$200000</option>
                                                <option value="300000">$300000</option>
                                                <option value="400000">$400000</option>
                                                <option value="500000">$500000</option>
                                                <option value="600000">$600000</option>
                                                <option value="700000">$700000</option>
                                                <option value="800000">$800000</option>
                                                <option value="900000">$900000</option>
                                                <option value="1000000">$1000000</option>
                                                <option value="1500000">$1500000</option>
                                                <option value="2000000">$2000000</option>
                                                <option value="2500000">$2500000</option>
                                                <option value="5000000">$5000000</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="property-max-price">Max Prices</label>
                                            <select name="max-price" id="property-max-price" >
                                                <option value="any" selected="selected">Any</option>
                                                <option value="5000">$5000</option>
                                                <option value="10000">$10000</option>
                                                <option value="50000">$50000</option>
                                                <option value="100000">$100000</option>
                                                <option value="200000">$200000</option>
                                                <option value="300000">$300000</option>
                                                <option value="400000">$400000</option>
                                                <option value="500000">$500000</option>
                                                <option value="600000">$600000</option>
                                                <option value="700000">$700000</option>
                                                <option value="800000">$800000</option>
                                                <option value="900000">$900000</option>
                                                <option value="1000000">$1000000</option>
                                                <option value="1500000">$1500000</option>
                                                <option value="2000000">$2000000</option>
                                                <option value="2500000">$2500000</option>
                                                <option value="5000000">$5000000</option>
                                                <option value="10000000">$10000000</option>
                                            </select>
                                        </div>
                                    </fieldset>
                                </div>
                                <button type="submit" class="btn btn-default btn-lg text-center btn-3d" data-hover="Search Property">Search Property</button>
                            </div>
                        </form>
                    </div>
                </section>


                {{----}}
                <section class="widget property-taxonomies clearfix _none-">
                    <h5 class="title">Recent Status</h5>
                    <ul class="clearfix">
                        <li><a href="single-property.html#">For Rent </a><span class="pull-right">29</span></li>
                        <li><a href="single-property.html#">For Sale </a><span class="pull-right">35</span></li>
                        <li><a href="single-property.html#">Office For Rent </a><span class="pull-right">07</span></li>
                    </ul>
                </section>


                {{----}}
                <section class="widget property-taxonomies clearfix _none-">
                    <h5 class="title">Recent Type</h5>
                    <ul class="clearfix">
                        <li><a href="single-property.html#">Apartment </a><span class="pull-right">30</span></li>
                        <li><a href="single-property.html#">Loft </a><span class="pull-right">05</span></li>
                        <li><a href="single-property.html#">Single Family Home </a><span class="pull-right">28</span></li>
                        <li><a href="single-property.html#">Vila </a><span class="pull-right">37</span></li>
                    </ul>
                </section>


            </div>
        </div>


    </div>
</div>