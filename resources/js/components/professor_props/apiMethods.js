const apiMethods = {
    dataDelete(){
        axios({
            method: 'post',
            url: 'api/professor/delete',
            data: {id: this.deleteData.id}
        }).then(() =>{
            this.deleteDialog = false
            this.getProfessorData()
        })
    },

    updateData(){
        if(this.$refs.Edit.validate()){
            var myform = document.getElementById('Edit');
            var formdata = new FormData(myform);
            axios({
                method: 'post',
                url: 'api/professor/update',
                data: formdata
            }).then(() =>{
                this.editDialog = false
                this.getProfessorData()
            })
        }

    },

    saveData(){
        if(this.$refs.Insert.validate()){
            var myForm = document.getElementById('Insert')
            var formData = new FormData(myForm)

            axios({
                method: 'post',
                url: 'api/professor/insert',
                data: formData
            }).then(() =>{
                this.insertDialog = false
                this.$refs.Insert.reset()
                this.getProfessorData()
            })
        }
    },

  };
  
  export default apiMethods;
  