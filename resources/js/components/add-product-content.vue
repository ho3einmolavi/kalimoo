<template>
    <div class="col-xs col-sm col-10 col-md-11 col-lg-9 col-xl-9 users-main delete-padding-left">
        <div class="ui-state-default user-list-info-box-add">
            <div class="admin-form col-md-8">
                <form class="needs-validation" novalidate>

                    <div class="form-group col-xs col-sm col- col-md col-lg col-xl-12">
                        <label for="inputname">نام محصول</label>
                        <input type="text" v-model="title" class="form-control" id="inputname" placeholder="نام محصول را وارد کنید">
                    </div>
                    <div class="form-group col-xs col-sm col-10 col-md col-lg col-xl-12">
                        <label for="validationTextarea">توضیحات محصول(اختیاری)</label>
                        <textarea class="form-control" v-model="description" id="validationTextarea" placeholder="توضیحات محصول را وارد کنید" required=""></textarea>
                        <div class="invalid-feedback">
                            لطفا توضیحات محصول را وارد کنید
                        </div>
                    </div>

                    <div class="form-group col-xs col-sm col-10 col-md col-lg col-xl-12">
                        <label for="inputState1">دسته بندی محصول</label>
                        <select id="inputState1" class="form-control form-option select-size" v-model="main_id">
                            <option v-for="item in thirds" v-bind:key="item.id" :value="item.id">
                                {{item.name}}
                            </option>
                        </select>
                    </div>
                    <div class="form-group col-xs col-sm col-10 col-md col-lg col-xl-12">
                        <label for="inputState">برند محصول را انتخاب کنید</label>
                        <select id="inputState" class="form-control form-option select-size" v-model="brand_id">
                            <option v-for="br in brands" v-bind:key="br.id" :value="br.id">{{br.name}}</option>
                        </select>
                    </div>
                    <div class="form-group col-xs col-sm col-10 col-md col-lg col-xl-12">
                        <label for="inputEmail4">قیمت (به تومان)</label>
                        <input type="text" v-model="price" class="form-control" id="inputEmail4" placeholder="قیمت محصول را وارد کنید">
                    </div>
                    <div class="form-group col-xs col-sm col-10 col-md col-lg col-xl-12">
                        <label for="inputname2">چند درصد میخواهید تخفیف دهید؟ (به طور مثال 10 درصد)</label>
                        <input type="number" v-model="discount" class="form-control" id="inputname2" placeholder="تخفیف">
                    </div>
                    <div class="form-group col-xs col-sm col-10 col-md col-lg col-xl-12">
                        <label for="inputname21">تعداد موجودی </label>
                        <input type="number" v-model="number" class="form-control" id="inputname21" placeholder="تعداد موجودی را وارد کنید">
                    </div>

                    <div class="form-group col-xs col-sm col-10 col-md col-lg col-xl-12">
                        <label for="inputname211">محدودیت برای حداکثر سفارش </label>
                        <input type="number" v-model="limit" class="form-control" id="inputname211" placeholder="محدودیت برای حداکثر سفارش">
                    </div>


                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="customFile" ref="img" v-on:change="handle()">
                        <label class="custom-file-label" for="customFile" style="margin-right: 15px;margin-top: 10px;">انتخاب عکس</label>
                    </div>

                    <button class="btn btn-primary" type="button" v-on:click="store" style="margin-top: 30px;font-size: 13px;margin-right: 20px;"> افزودن محصول </button>
                </form>
            </div>
            <div class="progress">
                <div class="progress-bar" role="progressbar" :style="'width:'+ percent + '%'" :aria-valuenow="percent" aria-valuemin="0" aria-valuemax="100">{{percent}}%</div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "add-product-content" ,

        created() {
            this.get_brands();
            this.get_third_cats();
        } ,

        data() {
            return {
                percent: 0 ,
                thirds: [] ,
                brands: [] ,
                main_id: '' ,
                title: '' ,
                description: '' ,
                price: '' ,
                brand_id: '' ,
                discount: 0 ,
                number: 0 ,
                img: '' ,
                limit: '' ,
            }
        } ,

        methods: {
            handle() {
                this.img = this.$refs.img.files[0];
            } ,
            store() {
                this.percent = 0;
                let file = this.img;
                if (file !== '' && file !== null)
                {
                    let data = new FormData();
                    data.append('title' , this.title);
                    data.append('description' , this.description);
                    data.append('third_category_id' , this.main_id);
                    data.append('price' , this.price);
                    data.append('brand_id' , this.brand_id);
                    data.append('discount' , (100 - this.discount) / 100);
                    data.append('number' , this.number);
                    data.append('limit' , this.limit);
                    data.append('product_img' , file);
                    axios({
                        url: '/api/store' ,
                        method: 'post' ,
                        data: data ,
                        onUploadProgress: uploadEvent => {
                            this.percent = Math.round(uploadEvent.loaded / uploadEvent.total * 100);
                        }
                    })
                        .then(res => {
                            console.log(res);
                            this.brands = res.data;
                            this.$toasted.success('محصول با موفقیت اضافه شد' , {
                                position: 'bottom-center' ,
                                theme: 'bubble' ,
                                fitToScreen: true ,
                                className: ['your-custom-class']
                            }).goAway(1500);
                        })
                        .catch(err => {
                            console.log(err.response);
                            err.response.data.forEach(error => {
                                this.$toasted.error(error , {
                                    position: 'bottom-center' ,
                                    theme: 'bubble' ,
                                    fitToScreen: true ,
                                    className: ['your-custom-class']
                                }).goAway(3000);
                            });
                            this.brands = [];
                        })
                }
                else
                {
                    axios({
                        url: '/api/store' ,
                        method: 'post' ,
                        onUploadProgress: uploadEvent => {
                            this.percent = Math.round(uploadEvent.loaded / uploadEvent.total * 100);
                        } ,
                        data: {
                            title:this.title ,
                            description: this.description ,
                            third_category_id: this.main_id ,
                            price: this.price ,
                            brand_id: this.brand_id ,
                            discount: (100 - this.discount) / 100 ,
                            number: this.number ,
                            limit: this.limit ,
                        }
                    })
                        .then(res => {
                            console.log(res);
                            this.brands = res.data;
                            this.$toasted.success('محصول با موفقیت اضافه شد' , {
                                position: 'bottom-center' ,
                                theme: 'bubble' ,
                                fitToScreen: true ,
                                className: ['your-custom-class']
                            }).goAway(1500);
                        })
                        .catch(err => {
                            console.log(err.response);
                            err.response.data.forEach(error => {
                                this.$toasted.error(error, {
                                    position: 'bottom-center',
                                    theme: 'bubble',
                                    fitToScreen: true,
                                    className: ['your-custom-class']
                                }).goAway(3000);
                            });
                            this.brands = [];
                        })
                }

            } ,
            get_brands() {
                axios({
                    url: `/api/brands` ,
                    method: 'get' ,
                })
                    .then(res => {
                        console.log(res);
                        this.brands = res.data;
                    })
                    .catch(err => {
                        console.log(err.response);
                        this.brands = [];
                    })
            } ,
            get_third_cats() {
                axios({
                    url: '/api/all/third' ,
                    method: 'get' ,
                })
                    .then(res => {
                        console.log(res);
                        this.thirds = res.data;
                    })
                    .catch(err => {
                        console.log(err.response);
                    })
            } ,
        }
    }
</script>

<style scoped>

</style>