<template>
    <div>
        <div class="row">
            <error-message @close="errorMessage = null" :message="errorMessage" ></error-message>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                    <label class="required">CEP</label>
                    <input type="text" class="form-control" name="cep" id="cep" v-mask="'#####-###'" v-model="cep" @blur="findAddress()">
                </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-6" id="link_search_cep">
                <a href="#" @click="zipCodeCorreios()">Consultar CEP no portal dos Correios</a>                    
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="required">Cidade</label>
                    <input type="text" class="form-control" name="city" id="city" v-model="address.localidade">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="required">Bairro</label>
                    <select class="form-control" name="district" id="district">
                        <option value=''>Selecione</option>
                        <option v-for="district in districts" :selected="district.name == address.bairro" :value="district.id"> {{ district.display_name }} </option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="required">Logradouro</label>
                    <input type="text" class="form-control" name="street" id="street" v-model="address.logradouro">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="required">Número</label>
                    <input type="text" class="form-control number" name="number" id="number" v-model="number">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Complemento</label>
                    <input type="text" class="form-control" name="complement" id="complement" v-model="complement">
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        props:[
            'districts',
            'addressOld'
        ],
    	data: function(){
            return {
                url: '',
                cep: '',
                address: [],
                errorMessage: null,
                number: '',
                complement: '',
            }
    	},
        methods: {
            findAddress(){
                if(this.cep.length == 9){
                    var route = "https://viacep.com.br/ws/"+ this.cep +"/json/";
                    $.ajax(route, {
                        success: function(address) {
                            this.errorMessage = null;
                            if(address.hasOwnProperty('erro')) this.errorMessage = "CEP não encontrado!";
                            this.address = address;
                            number.focus();
                        }.bind(this),
                        error: function() {
                            this.errorMessage = "Ocorreu um erro ao buscar o CEP!";
                        }.bind(this)
                    });
                }else if(this.cep.length > 1){
                    this.errorMessage = "CEP inválido!";
                }
            },
            zipCodeCorreios(){
                this.url = "http://www.buscacep.correios.com.br/sistemas/buscacep/buscaCepEndereco.cfm";
                window.open(this.url, '', 'resizable=yes');
            },
            fillFieldsWithOldData(){
                this.cep = this.addressOld.cep;
                this.address.localidade = this.addressOld.city;
                this.address.logradouro = this.addressOld.street;
                this.number = this.addressOld.number;
                this.complement = this.addressOld.complement;
                for (var i in this.districts) {
                    if(this.districts[i].id == this.addressOld.district){
                        this.address.bairro = this.districts[i].name;
                    }
                }
            }
        },
        created(){
            this.fillFieldsWithOldData();
        }
    }
</script>