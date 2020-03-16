<template>
   <div id="buttons">
        <div class="row">
            <div class="col-md-12">
                <div class="checkbox text-center">
                    <label for="accept_term">
                        <input name="accept_term" type="checkbox" value="1" id="accept_term" v-model="acceptTerm">
                        Li e aceito os termos e condições
                    </label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group">
                <div class="col-lg-12">
                    <div class="terms_and_conditions">
                        <p>           
                            Declaro que todas as informações prestadas são verídicas não havendo omissões ou dados que 
                            possam induzir a equívocos de  julgamentos e assumo total responsabilidade pelo conteúdo 
                            dessa declaração e estou ciente que as  inscrições poderão ser anuladas a qualquer tempo, 
                            desde que verificadas falsidades, inexatidões de declarações e ou irregularidades na inscrição, 
                            entrevista e documentos apresentados.
                        </p>
                        <p>
                            A inscrição do candidato implicará conhecimento e cumprimento das instruções do Edital e aceitação 
                            tácita das condições nele contidas, não podendo o candidato, após a confirmação da inscrição, 
                            alegar desconhecimento das normas aqui estabelecidas.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="pull-right">
            <a :href="btnCancel" class="btn-back">Cancelar</a>
            <button class="btn-save" type="submit" :disabled="blockSave">Avançar</button>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            validatedForm: {
                type:Boolean,
                default: true
            }
        },
    	data: function(){
    		return {
                acceptTerm:false,
                btnCancel: laroute.route('public.index')
    		}
        },
        computed: {
            blockSave(){
                return !this.acceptTerm || !this.validatedForm;
            }
        },
    }
</script>