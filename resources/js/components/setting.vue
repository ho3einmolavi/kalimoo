<template>
    <div class="col-xs col-sm col-10 col-md-10 col-lg-9 col-xl-9 users-main delete-padding-left">
        <div class="ui-state-default user-list-info-box-add">
            <div class="admin-form col-xs col-sm col- col-md col-lg col-xl-8">
                <form class="needs-validation" novalidate="">

                    <div class="form-group col-md-12">
                        <label for="inputname">عنوان سایت </label>
                        <input type="text" v-model="setting_data.title" class="form-control" id="inputname" placeholder="عنوان سایت را وارد کنید">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="inputname343">حداقل قیمت سفارش </label>
                        <input type="number" v-model="setting_data.minimum_order_cost" class="form-control" id="inputname343" placeholder="حداقل قیمت سفارش را وارد کنید">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="inputname343">هزینه ارسال سفارش </label>
                        <input type="number" v-model="setting_data.sending_cost" class="form-control" id="inputname343" placeholder="حداقل قیمت سفارش را وارد کنید">
                    </div>



                    <div class="form-group col-md-12">
                        <label for="validationTextarea"> توضیحات وب سایت </label>
                        <textarea class="form-control" v-model="setting_data.description" id="validationTextarea" placeholder="توضیحات مربوط به سایت را وارد کنید" required=""></textarea>
                        <div class="invalid-feedback">
                            لطفا توضیحات  دسته را واد کنید
                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="inputEmail4"> کلمات کلیدی</label>
                        <textarea class="form-control" id="inputEmail4" v-model="setting_data.keywords" placeholder=" کلمات کلیدی را با کاما از هم جدا کنید. مثال کتاب,چاپ,اصفهان" required=""></textarea>
                        <div class="invalid-feedback">
                            لطفا توضیحات  دسته را واد کنید
                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="inputEmail43"> آدرس </label>
                        <textarea class="form-control" v-model="setting_data.address" id="inputEmail43" placeholder=" آدرس خود را وارد کنید" required=""></textarea>
                        <div class="invalid-feedback">
                            آدرس خود را وارد کنید
                        </div>
                    </div>


                    <div class="form-group col-md-12">
                        <label for="inputname1"> شماره تماس  </label>
                        <input type="text" class="form-control" v-model="setting_data.consultant_number" id="inputname1" placeholder="شماره تماس  مشاوره">
                    </div>


                    <div class="form-group col-md-12">
                        <label for="inputname3">  تلگرام </label>
                        <input type="text" class="form-control" id="inputname3" v-model="setting_data.telegram" placeholder="شماره را وارد کنید">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="inputname6">  اینستاگرام </label>
                        <input type="text" class="form-control" v-model="setting_data.instagram" id="inputname6" placeholder="آدرس  اینستاگرام خود را وارد کنید">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="inputname6">  توییتر </label>
                        <input type="text" class="form-control" v-model="setting_data.email" id="inputname6" placeholder="آدرس  اینستاگرام خود را وارد کنید">
                    </div>


                    <div class="form-group col-md-12">
                        <label for="inputname6">  لینکدین </label>
                        <input type="text" class="form-control" v-model="setting_data.consultant_mobile" id="inputname6" placeholder="آدرس  اینستاگرام خود را وارد کنید">
                    </div>

                    <div class="form-group col-md-12">
                        <label for="inputname5">ایمیل  </label>
                        <input type="text" class="form-control" v-model="setting_data.email_info" id="inputname5" placeholder="آدرس ایمیل را وارد کنید">
                    </div>


                    <div class="custom-file" style="margin-top: 25px;text-align: left;margin-right: 15px;">
                        <input type="file" class="custom-file-input" id="logo1" ref="logo" v-on:change="handle">
                        <label class="custom-file-label" for="logo1"> عکس لوگو را آپلود کنید  </label>
                    </div>
                    <button class="btn btn-primary" v-on:click="get_setting" type="button" style="margin-top: 20px;font-size: 13px;margin-right: 15px;">  ذخیره تغییرات </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        created() {
            this.update_local();
            console.log('setting mounted.');
        } ,


        data() {
            return {
                setting_data: {
                    title: '' ,
                    description: '' ,
                    keywords: '' ,
                    address: '' ,
                    consultant_mobile: '' ,
                    consultant_number: '' ,
                    sending_cost: '' ,
                    telegram: '',
                    email: '' ,
                    email_info: '' ,
                    instagram: '' ,
                    account_number: '' ,
                    minimum_order_cost: '' ,
                    card_number: '' ,
                    account_owner: '' ,
                    logo1: ''
                }
            }
        } ,

        methods: {
            update_local() {
                axios({
                    url: '/api/setting/index' ,
                    method: 'get' ,
                    headers: {
                        accept: 'application/json'
                    } ,
                })
                    .then(res => {
                        console.log(res);
                        this.setting_data = res.data[0];
                    })
                    .catch(err => {
                        console.log(err.response);
                        this.$toasted.error(err.response.data, {
                            position: 'bottom-center' ,
                            theme: 'bubble' ,
                            fitToScreen: true
                        }).goAway(3000);
                    })
            } ,
            handle() {
                this.logo1 = this.$refs.logo.files[0];
                this.logo(this.logo1)
            } ,
            logo(file) {
                let data = new FormData();
                if (file !== '' && file !== null)
                {
                    swal({
                        title: 'در حال آپلود' ,
                        text: ' لطفا منتظر بمانید ...' ,
                        className: 'your-custom-class' ,
                        icon: 'warning'
                    });
                    data.append('logo' , file);
                    axios({
                        url: '/api/logo' ,
                        method: 'post' ,
                        headers: {
                            accept: 'application/json'
                        } ,
                        data: data
                    })
                        .then(res => {
                            console.log(res.data);
                            swal({
                                title: 'تغییرات با موفقیت اعمال شد' ,
                                text: 'لوگو با موفقیت تغییر کرد' ,
                                className: 'your-custom-class' ,
                                icon: 'success'
                            });
                        })
                        .catch(err => {
                            console.log(err.response);
                            swal({
                                title: 'خطا' ,
                                text: err.response.data[0] ,
                                className: 'your-custom-class' ,
                                icon: 'error'
                            });
                        })
                }
                else
                {
                    this.$toasted.error('فایل انتخاب شده قابل ارسال نیست', {
                        position: 'bottom-center' ,
                        theme: 'bubble' ,
                        fitToScreen: true
                    }).goAway(3000);
                }

            } ,
            get_setting() {
                axios({
                    url: '/api/setting' ,
                    method: 'post' ,
                    headers: {
                        accept: 'application/json'
                    } ,
                    data: {
                        title: this.setting_data.title ,
                        description: this.setting_data.description ,
                        keywords: this.setting_data.keywords ,
                        address: this.setting_data.address ,
                        consultant_mobile: this.setting_data.consultant_mobile ,
                        consultant_number: this.setting_data.consultant_number ,
                        telegram: this.setting_data.telegram,
                        email: this.setting_data.email ,
                        email_info: this.setting_data.email_info ,
                        sending_cost: this.setting_data.sending_cost ,
                        instagram: this.setting_data.instagram ,
                        minimum_order_cost: this.setting_data.minimum_order_cost ,
                        account_number: this.setting_data.account_number ,
                        card_number: this.setting_data.card_number ,
                        account_owner: this.setting_data.account_owner ,

                    }
                })
                    .then(res => {
                        console.log(res);
                        this.setting_data = res.data;
                        this.$toasted.success('تنظیمات اعمال شد' , {
                            position: 'bottom-center' ,
                            theme: 'bubble' ,
                            fitToScreen: true ,
                            className: ['your-custom-class']
                        }).goAway(2000);
                    })
                    .catch(err => {
                        console.log(err.response);
                        err.response.data.forEach(error => {
                            this.$toasted.error(error.toString() , {
                                position: 'bottom-center' ,
                                theme: 'bubble' ,
                                fitToScreen: true ,
                                className: ['your-custom-class']
                            }).goAway(3000);
                        })
                    })
            }
        }
    }
</script>

<style scoped>

</style>