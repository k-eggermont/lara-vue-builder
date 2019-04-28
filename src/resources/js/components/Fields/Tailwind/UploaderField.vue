<template>
    <div class="form-group" :class="{ 'error': isError }">
        <label :for="field.field+'_form'">
            {{ field.name }}
        </label>
        <div class="relative">



            <div class="border-2 rounded border-grey-lighter p-4 text-blue text-lg  font-semibold" v-if="maxFilesReached">

                <p class="mb-2">
                    <svg fill="#3490dc" width="80" height="80" enable-background="new 0 0 24 24" id="Layer_1" version="1.0" viewBox="0 0 24 24" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><path d="M12,4c4.4,0,8,3.6,8,8s-3.6,8-8,8s-8-3.6-8-8S7.6,4,12,4 M12,2C6.5,2,2,6.5,2,12c0,5.5,4.5,10,10,10s10-4.5,10-10   C22,6.5,17.5,2,12,2L12,2z"/></g><line fill="none" stroke="#3490dc" stroke-miterlimit="10" stroke-width="2" x1="18.2" x2="5.8" y1="18.2" y2="5.8"/></svg>
                </p>
                No more file !
            </div>

            <div class="relative border-2 rounded border-grey-lighter p-4 text-blue text-lg   font-semibold" v-else-if="loading">

                <svg class="absolute pin-l pin-t w-full mt-10" viewBox="0 0 120 30" style="height:50px;" xmlns="http://www.w3.org/2000/svg" fill="#3681ee">
                    <circle cx="15" cy="15" r="13.9981">
                        <animate attributeName="r" from="15" to="15" begin="0s" dur="0.8s" values="15;9;15" calcMode="linear" repeatCount="indefinite"></animate>
                        <animate attributeName="fill-opacity" from="1" to="1" begin="0s" dur="0.8s" values="1;.5;1" calcMode="linear" repeatCount="indefinite"></animate>
                    </circle>
                    <circle cx="60" cy="15" r="10.0019" fill-opacity="0.3">
                        <animate attributeName="r" from="9" to="9" begin="0s" dur="0.8s" values="9;15;9" calcMode="linear" repeatCount="indefinite"></animate>
                        <animate attributeName="fill-opacity" from="0.5" to="0.5" begin="0s" dur="0.8s" values=".5;1;.5" calcMode="linear" repeatCount="indefinite"></animate>
                    </circle>
                    <circle cx="105" cy="15" r="13.9981">
                        <animate attributeName="r" from="15" to="15" begin="0s" dur="0.8s" values="15;9;15" calcMode="linear" repeatCount="indefinite"></animate>
                        <animate attributeName="fill-opacity" from="1" to="1" begin="0s" dur="0.8s" values="1;.5;1" calcMode="linear" repeatCount="indefinite"></animate>
                    </circle>
                </svg>

                <div class="opacity-25">
                    <p>
                        <svg height="90px" version="1.1" viewBox="0 0 32 32" width="90px" xmlns="http://www.w3.org/2000/svg" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" xmlns:xlink="http://www.w3.org/1999/xlink"><title/><desc/><defs/><g fill="none" fill-rule="evenodd" id="Page-1" stroke="none" stroke-width="1"><g fill="#157EFB" id="icon-130-cloud-upload"><path d="M16,16 L12.75,19.25 L12,18.5 L16.5,14 L21,18.5 L20.25,19.25 L17,16 L17,27 L16,27 L16,16 L16,16 Z M15,21 L8.00281647,21 C5.79793835,21 4,19.209139 4,17 C4,15.1046097 5.32460991,13.5117359 7.10100919,13.1021544 L7.10100919,13.1021544 C7.03467626,12.7448817 7,12.3764904 7,12 C7,8.68629134 9.68629134,6 13,6 C15.6154416,6 17.8400262,7.67345685 18.6614243,10.0080411 C19.435776,9.37781236 20.4237666,9 21.5,9 C23.8583427,9 25.7929639,10.814166 25.9844379,13.1230721 L25.9844379,13.1230721 C27.7144917,13.5630972 29,15.1320162 29,17 C29,19.2046438 27.207878,21 24.9971835,21 L18,21 L18,22 L25.0005601,22 C27.7616745,22 30,19.7558048 30,17 C30,14.9035809 28.7132907,13.1085075 26.8828633,12.3655101 L26.8828633,12.3655101 C26.3600217,9.87224935 24.1486546,8 21.5,8 C20.6371017,8 19.8206159,8.19871575 19.0938083,8.55288165 C17.8911816,6.43144875 15.6127573,5 13,5 C9.13400656,5 6,8.13400656 6,12 C6,12.1381509 6.00400207,12.275367 6.01189661,12.4115388 L6.01189661,12.4115388 C4.23965876,13.1816085 3,14.9491311 3,17 C3,19.7614237 5.23249418,22 7.99943992,22 L15,22 L15,21 L15,21 L15,21 Z" id="cloud-upload"/></g></g></svg>
                    </p>
                    Click here to upload
                    <p class="text-center text-grey-dark text-xs mt-1">MAX 1 FILE, AND 400KB PER FILE.</p>
                </div>
            </div>



            <label class="border-2 text-center rounded border-grey-lighter p-4 text-blue text-lg hover:border-blue cursor-pointer font-semibold" v-else>

                <p class="text-center">
                    <svg height="90px" version="1.1" viewBox="0 0 32 32" width="90px" xmlns="http://www.w3.org/2000/svg" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" xmlns:xlink="http://www.w3.org/1999/xlink"><title/><desc/><defs/><g fill="none" fill-rule="evenodd" id="Page-1" stroke="none" stroke-width="1"><g fill="#157EFB" id="icon-130-cloud-upload"><path d="M16,16 L12.75,19.25 L12,18.5 L16.5,14 L21,18.5 L20.25,19.25 L17,16 L17,27 L16,27 L16,16 L16,16 Z M15,21 L8.00281647,21 C5.79793835,21 4,19.209139 4,17 C4,15.1046097 5.32460991,13.5117359 7.10100919,13.1021544 L7.10100919,13.1021544 C7.03467626,12.7448817 7,12.3764904 7,12 C7,8.68629134 9.68629134,6 13,6 C15.6154416,6 17.8400262,7.67345685 18.6614243,10.0080411 C19.435776,9.37781236 20.4237666,9 21.5,9 C23.8583427,9 25.7929639,10.814166 25.9844379,13.1230721 L25.9844379,13.1230721 C27.7144917,13.5630972 29,15.1320162 29,17 C29,19.2046438 27.207878,21 24.9971835,21 L18,21 L18,22 L25.0005601,22 C27.7616745,22 30,19.7558048 30,17 C30,14.9035809 28.7132907,13.1085075 26.8828633,12.3655101 L26.8828633,12.3655101 C26.3600217,9.87224935 24.1486546,8 21.5,8 C20.6371017,8 19.8206159,8.19871575 19.0938083,8.55288165 C17.8911816,6.43144875 15.6127573,5 13,5 C9.13400656,5 6,8.13400656 6,12 C6,12.1381509 6.00400207,12.275367 6.01189661,12.4115388 L6.01189661,12.4115388 C4.23965876,13.1816085 3,14.9491311 3,17 C3,19.7614237 5.23249418,22 7.99943992,22 L15,22 L15,21 L15,21 L15,21 Z" id="cloud-upload"/></g></g></svg>
                </p>
                <p class="text-center font-semibold">
                    Click here to upload
                </p>
                <p class="text-center text-grey-dark text-xs mt-1">MAX 1 FILE, AND 400KB PER FILE.</p>


                <input type="file" ref="input" class="hidden" @change="onFileChange($event.target.name, $event.target.files)" :accept="accept">
            </label>

            <ul class="list-reset leading-normal text-left mt-4">
                <li class="flex items-center mb-1 font-semibold text-blue justify-between" v-for="(file,key) in defaultFiles">
                    <span class="flex items-center">
                        <a href="#" v-on:click.prevent="deleteDefaultFile(key)"><svg class="mr-3" id="Layer_1" fill="#000" height="28" width="28" style="enable-background:new 0 0 64 64;" version="1.1" viewBox="0 0 64 64" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><g id="Icon-Trash" transform="translate(232.000000, 228.000000)"><polygon class="st0" id="Fill-6" points="-207.5,-205.1 -204.5,-205.1 -204.5,-181.1 -207.5,-181.1    "/><polygon class="st0" id="Fill-7" points="-201.5,-205.1 -198.5,-205.1 -198.5,-181.1 -201.5,-181.1    "/><polygon class="st0" id="Fill-8" points="-195.5,-205.1 -192.5,-205.1 -192.5,-181.1 -195.5,-181.1    "/><polygon class="st0" id="Fill-9" points="-219.5,-214.1 -180.5,-214.1 -180.5,-211.1 -219.5,-211.1    "/><path class="st0" d="M-192.6-212.6h-2.8v-3c0-0.9-0.7-1.6-1.6-1.6h-6c-0.9,0-1.6,0.7-1.6,1.6v3h-2.8v-3     c0-2.4,2-4.4,4.4-4.4h6c2.4,0,4.4,2,4.4,4.4V-212.6" id="Fill-10"/><path class="st0" d="M-191-172.1h-18c-2.4,0-4.5-2-4.7-4.4l-2.8-36l3-0.2l2.8,36c0.1,0.9,0.9,1.6,1.7,1.6h18     c0.9,0,1.7-0.8,1.7-1.6l2.8-36l3,0.2l-2.8,36C-186.5-174-188.6-172.1-191-172.1" id="Fill-11"/></g></g></svg></a>
                    {{ getUri(file) }}
                        </span>
                    <a target="_blank" :href="file" class="bg-grey-lighter hover:bg-grey-light text-white px-2 py-1 text-xs rounded">

                        <svg width="12px" height="12px" id="Capa_1" style="enable-background:new 0 0 80 80;" version="1.1" viewBox="0 0 80 80"  xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><path d="M29.298,63.471l-4.048,4.02c-3.509,3.478-9.216,3.481-12.723,0c-1.686-1.673-2.612-3.895-2.612-6.257   s0.927-4.585,2.611-6.258l14.9-14.783c3.088-3.062,8.897-7.571,13.131-3.372c1.943,1.93,5.081,1.917,7.01-0.025   c1.93-1.942,1.918-5.081-0.025-7.009c-7.197-7.142-17.834-5.822-27.098,3.37L5.543,47.941C1.968,51.49,0,56.21,0,61.234   s1.968,9.743,5.544,13.292C9.223,78.176,14.054,80,18.887,80c4.834,0,9.667-1.824,13.348-5.476l4.051-4.021   c1.942-1.928,1.953-5.066,0.023-7.009C34.382,61.553,31.241,61.542,29.298,63.471z M74.454,6.044   c-7.73-7.67-18.538-8.086-25.694-0.986l-5.046,5.009c-1.943,1.929-1.955,5.066-0.025,7.009c1.93,1.943,5.068,1.954,7.011,0.025   l5.044-5.006c3.707-3.681,8.561-2.155,11.727,0.986c1.688,1.673,2.615,3.896,2.615,6.258c0,2.363-0.928,4.586-2.613,6.259   l-15.897,15.77c-7.269,7.212-10.679,3.827-12.134,2.383c-1.943-1.929-5.08-1.917-7.01,0.025c-1.93,1.942-1.918,5.081,0.025,7.009   c3.337,3.312,7.146,4.954,11.139,4.954c4.889,0,10.053-2.462,14.963-7.337l15.897-15.77C78.03,29.083,80,24.362,80,19.338   C80,14.316,78.03,9.595,74.454,6.044z"/></g><g/><g/><g/><g/><g/><g/><g/><g/><g/><g/><g/><g/><g/><g/><g/></svg>

                    </a>

                </li>
                <li class="flex items-center mb-1 font-semibold text-blue justify-between" v-for="(file,key) in files">
                    <span class="flex items-center">

                        <a href="#" v-on:click.prevent="deleteFile(key)"><svg class="mr-3" id="Layer_1" fill="#000" height="28" width="28" style="enable-background:new 0 0 64 64;" version="1.1" viewBox="0 0 64 64" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g><g id="Icon-Trash" transform="translate(232.000000, 228.000000)"><polygon class="st0" id="Fill-6" points="-207.5,-205.1 -204.5,-205.1 -204.5,-181.1 -207.5,-181.1    "/><polygon class="st0" id="Fill-7" points="-201.5,-205.1 -198.5,-205.1 -198.5,-181.1 -201.5,-181.1    "/><polygon class="st0" id="Fill-8" points="-195.5,-205.1 -192.5,-205.1 -192.5,-181.1 -195.5,-181.1    "/><polygon class="st0" id="Fill-9" points="-219.5,-214.1 -180.5,-214.1 -180.5,-211.1 -219.5,-211.1    "/><path class="st0" d="M-192.6-212.6h-2.8v-3c0-0.9-0.7-1.6-1.6-1.6h-6c-0.9,0-1.6,0.7-1.6,1.6v3h-2.8v-3     c0-2.4,2-4.4,4.4-4.4h6c2.4,0,4.4,2,4.4,4.4V-212.6" id="Fill-10"/><path class="st0" d="M-191-172.1h-18c-2.4,0-4.5-2-4.7-4.4l-2.8-36l3-0.2l2.8,36c0.1,0.9,0.9,1.6,1.7,1.6h18     c0.9,0,1.7-0.8,1.7-1.6l2.8-36l3,0.2l-2.8,36C-186.5-174-188.6-172.1-191-172.1" id="Fill-11"/></g></g></svg></a>
                    {{ file.name }}
                        </span>

                    <span class="bg-blue text-white px-2 py-1 text-xs rounded">NEW</span>



                </li>
            </ul>


            <select v-if="true==false" :name="field.field" :id="field.field+'_form'" :value="$parent.form[field.field]" :placeholder="field.placeholder" @input="updateField($event.target.value)">
                <option v-for="(value,key) in field.options" :value="key">{{ value }}</option>
            </select>

        </div>
        <div class="form-error" v-if="error.length > 0">
            {{ error[0] }}
        </div>

    </div>
</template>
<script>
    export default {

        props: ["field", "error", "isError"],
        mounted() {
            //this.attribute = this.field;
            //this.value = this.field.value;

            this.$emit("input",this.returnFiles)
        },

        data() { return {
            value: [],
            defaultFiles: ["http://www.google.fr/logo.jpg"],
            name: null,
            loading:false,
            files: [],
            props: {}
        }},

        computed: {
            maxFiles: function() {
                var maxFiles = 1;
                if(typeof this.field.maxFiles != "undefined") {
                    maxFiles = parseInt(this.field.maxFiles)
                }
                return maxFiles;
            },
            maxFilesReached: function() {

                if((this.files.length + this.defaultFiles.length) >= this.maxFiles) { return true; }
                return false;
            },
            returnFiles: function() {
                /*
                if(this.maxFiles == 1) {
                    if(this.defaultFiles.length >= 1) {
                        return this.defaultFiles[0];
                    } else if(this.files.length >= 1) {
                        return this.files[0];
                    } else {
                        return [];
                    }
                    return { base: this.defaultFiles, uploaded: this.files }
                }*/
                return { old: this.defaultFiles, uploaded: this.files, maxFiles: this.maxFiles }

            },
            accept: function () {
                var accept = []; /*
                    accept.push("image/*");
                    accept.push(".jpg");
                    accept.push(".jpeg");
                    accept.push(".JPG");
                    accept.push(".gif");
                    accept.push(".png");
                    accept.push(".bmp");
                }
                if(this.allowPdf) {
                    accept.push("application/pdf");
                    accept.push(".pdf");
                }*/
                return accept.join(",");
            }
        },

        methods: {

            getUri(str) {
                str = str.split('/');
                return str[str.length - 1]
            },

            updateField(data)  {
                this.$emit('input',data)
            },


            getSize: function(size) {
                return `${Math.round(((size * (3/4)) )/1024 * 100)/100} kb`;
            },

            buttonClick: function(e) {

                if(this.disable) return;
                if(this.files.length >= this.maxFiles) {
                    this.$swal({
                        type: 'error',
                        title: 'Erreur ..',
                        text: 'Vous ne pouvez pas uploader plus de '+this.maxFiles+' fichiers !',
                    })
                    this.loading = false;
                } else {
                    e.currentTarget.parentNode.querySelector("input").click()
                }

            },

            deleteFile: function(key) {
                this.files.splice(key,1);
                this.$emit('input',this.returnFiles);
            },

            deleteDefaultFile: function(key) {
                this.defaultFiles.splice(key,1);
                this.$emit('input', this.returnFiles);

            },


            onFileChange(fieldName, file) {
                this.loading = true;
                const { maxSize } = this
                let imageFile = file[0]

                if (file.length>0) {

                    this.loading = true;
                    let imageURL = URL.createObjectURL(imageFile)
                    var name = imageFile.name;
                    var type = imageFile.type;
                    var reader = new FileReader();



                    reader.onload = async (e) => {
                        let valid = true;
                        let reason = null;

                        this.loading = false;

                        if (valid) {
                            var base64 = e.target.result
                            this.files.push({ base64, imageURL, name, type });
                            this.$emit('input', this.returnFiles);
                            Bus.$emit('uploadFinished', { resourceId: this.resourceId })

                        } else {
                            Bus.$emit('invalidFile', { reason });
                        }
                    };
                    this.$refs.input.value = '';
                    reader.readAsDataURL(imageFile);
                }
            },

            matching: function (imageFile) {
                if(this.allowPdf === true && this.allowImage === true) {
                    if (imageFile.type.match('image.*') || imageFile.type.match('application/pdf')) {
                        return true;
                    }
                    return false;
                }
                if(this.allowPdf === true) {
                    if (imageFile.type.match('application/pdf')) {
                        return true;
                    }
                    return false;
                }
                if(this.allowImage === true) {
                    if (imageFile.type.match('image.*')) {
                        return true;
                    }
                    return false;
                }
            },

            lengthError: function() {
                this.loading = false;

                var errorText = 'Votre fichier est trop gros ! La taille maximale est de '+this.maxSize+'KB'
                this.$swal({
                    type: 'error',
                    title: 'Erreur !',
                    text: errorText
                })
            },
        }

    }
</script>
