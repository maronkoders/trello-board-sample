<template>
 <div class="ui">
	<nav class="navbar app">Trello Boards
     <button type="submit"  style="margin-left:10px;" class="btn " @click="logout($event)">
            LOGOUT
        </button>
  </nav>
	<nav class="navbar board">
    <button type="submit" class="btn" @click="showColumnModal()">
                                    Add Column
    </button>
  </nav>
	<div class="lists" >
		<div class="list" v-for="column in columns" :key="column.id">
			<header>{{column.title}}
           <a href=javascript:void(0);> 
             <button type="submit" style="float:right; margin-top:10px;" class="btn" @click="deleteColumn(column.id)">
                                    X
              </button>
          </a>
      </header>


		


			<ul>
        
        <li v-for="card in cards" :key="card.id" v-if="card.columnId === column.id">
              <span>
                {{card.title}}
                <br>
               <div style="height:5px; margin-top:5px;"></div>
                    
                    <button   type="submit" class="btn" @click="editCard(card)">
                        edit
                    </button>

                     <button  type="submit" class="btn" @click="deleteCard(card.id)">
                        remove
                    </button>
      
              </span>

         

            
               
        </li>
     
			</ul>
			<footer>


      <div v-if="column.id === selectedColumn"> 
        <div v-show="showForm">

          {{cardErrors}}
          <br>
             <input style="width:100%;" type="text" placeholder="title"  v-model="cardTitle">
             
           

        <textarea   style="width:100%;" type="text" placeholder="Description" v-model="cardDescription"></textarea>
        

        <br>
         <button type="submit" class="btn " @click="addCard(column.id)">
            Save
        </button>

        <button type="submit" class="btn " @click="closeForm($event)">
            cancel
        </button>
          </div>
      </div>
        
        <button type="submit" class="btn " @click="ShowCardform(column.id)">
                      Add new card
        </button>
      </footer>

      <modal name="my-first-modal" width="300" height="190">

        <div class="card" >  
          <div class="card-body"> 
            <h5 class="card-title">

              <strong>CREATE COLUMN </strong>
            </h5>
            
                    <form >
            <label for="fname">Title name:</label><br>
            <input type="text"  style="width:100%" v-model="columnTitle"><br>

              {{titleError}}

              <br>
            <input type="submit"  @click="addColumn()" value="Submit">
             <input type="submit"  @click="hide($event)" value="Close">
          </form> 

          </div>
        </div>
      </modal>
      <div class="circle-div">
        <input type="submit"  @click="exportDB($event)" value="EXPORT DB">
      </div>

		</div>
	</div>
</div>
</template>
<script>
import Vue from "vue";
import axios from "axios";
import VModal from 'vue-js-modal'
import 'vue-js-modal/dist/styles.css'
Vue.use(VModal)
export default {
    name: "home",
    components: {
        axios, VModal,
    filters:{
      getcolumnCards:function(value){
        let columnCards =[];
        this.cards.forEach(el =>{
          if(el.columnId === value.columnId)
          { 
            columnCards.push(el.title);
          }
        })
       return columnCards;
      }
    },
    },
    data() {
        return {
            columns:[],
            cards:[],
            columnTitle:"",
            columnId:"",
            cardDescription:"",
            cardTitle:"",
            title:"",
            showForm:false,
            selectedColumn:"",
            titleError:"",
            cardErrors:"",
            list:"<li> dsdsfsdfsdf</li>"
        };
    },
 
    methods: {
       logout: function() {
              setTimeout(() => {
                alert("Logging you out");
              }, 1000);
            axios
                .post("logout")
                .then(response => {
                    if (response.data.status === 200) {
                        setTimeout(() => {
                            window.location = window.origin;
                        }, 2000);
                    }
                })
                .catch(error => {
                    Vue.$toast.open({
                        message: error.message,
                        type: "error",
                        position: "top"
                    });
                });
        },

      exportDB:function()
      { 
        event.preventDefault();

         axios
                .post("api/exportDB")
                .then(response => {
                    if (response.data.status === 200) {
                      alert("The db was exported");
                    } else{
                      alert(response.data.message)
                    }
                })
                .catch(error => {
                    alert(error.data.message)
                });


      },
      hide:function()
      { 
          event.preventDefault();
        this.$modal.hide('my-first-modal');
      },
      showColumnModal () {

         this.$modal.show('my-first-modal');
          
        },
        editCard:function(card)
        {
            this.$modal.show(
                {
                  template: `
                    <div class="card">
                      <h4 style="text-align:center;">CARD DETAILS</h4>
                      <div class="card-body" style="-ms-flex: 1 1 auto;
	flex: 1 1 auto;
	min-height: 1px;
	padding: 1.2rem; margin-top:-30px;">
                        <label for="fname">Title name:</label><br>
                        <input style="width:100%;" type="text" v-model="title"><br>
                        <label for="fname">Card Description:</label><br>
                        <textarea  style="width:100%;"type="text" v-model="description"></textarea><br>
                       <button @click="$emit('updateCard',[title,description])">Update</button>
 <button @click="$emit('close')">Close</button>
                      </div>
                   
                    </div>
                  `,
                  props: ['title','description'],
     
                },
                { title: card.title , description:card.description},
                { width: 300,
                   height: 200},
                { 
                  'updateCard':this.updatecard
                },
                
              )
        },
  
      showCardsPerColumn:function(){  
        return 'sdsds';
      },
      updatecard:function()
      {
  
         console.log("im cliecke");
      },
      closeForm:function()
      {
        event.preventDefault();
          this.showForm = false;
      },  

      ShowCardform:function()
      {
        this.cardErrors ="";
         this.selectedColumn = arguments[0];
         this.showForm =true;
      },
      addColumn:function()
      {
        event.preventDefault();
         let payload = {
            title : this.columnTitle,
         }
         if(!this.columnTitle)
         {
             this.titleError ="Please enter title";
             
         }else{
           axios
                .post("api/column", payload)
                .then(response => {
                   this.$modal.hide('my-first-modal');
                   this.columnTitle ="";
                   this.titleError ="";
                    if (response.data.status === 200) {
                       this.columns.push(response.data.new_record);
                    } 
                })
                .catch(error => {
                    alert(error.message)
                });
         } 
      },
       addCard:function()
      {
         let payload = {
           title : this.cardTitle,
           description:this.cardDescription,
           columnId:arguments[0]
         }
         if(!this.cardTitle || !this.cardDescription)
         {
             this.cardErrors ="Fill in all details"
         }{
             axios
                .post("api/card", payload)
                .then(response => {
                    if (response.data.status === 200) {
                      this.cardTitle ="";
                      this.cardDescription="";
                      this.cards.push(response.data.new_record);
                      this.showForm = false;
                      this.cardErrors ="";
                    } 
                })
                .catch(error => {
                    alert(error.message)
                });
         }
      },
      deleteColumn:function()
      {
            axios
                .delete("api/column/"+arguments[0])
                .then(response => {
                    if (response.data.status === 204) {
                        const item = this.columns.findIndex((p) => p.id === arguments[0]);
                          this.columns.splice(item, 1);
                    } 
                })
                .catch(error => {
                  alert(error.message)
                });
      },
      deleteCard:function()
      {
            axios
                .delete("api/card/"+arguments[0])
                .then(response => {
                    if (response.data.status === 204) {
                      const item = this.cards.findIndex((p) => p.id === arguments[0]);
                          this.cards.splice(item, 1);
                    }
                })
                .catch(error => {
                    alert(error.message)
                });
      },
        getColumns: function() {
            axios
                .get("api/column")
                .then(response => {
                    if (response.status === 200) {
                       this.columns = response.data.records
                    } 
                })
                .catch(error => {
                    alert(error.message)
                });
        },
        getCards: function() {
            axios
                .get("api/card")
                .then(response => {
                    if (response.data.status === 200) {
                        this.cards = response.data.records;
                    } 
                })
                .catch(error => {
                    alert(error.message)
                });
        }
    },
    created() {
        this.getColumns();
        this.getCards();
    },
    mounted() {
        
    }
};
</script>
<style lang="scss" scoped>

$appbar-height: 40px;
$navbar-height: 50px;
$list-width: 300px;
$gap: 10px;
$scrollbar-thickness: 17px;
$list-header-height: 36px;
$list-footer-height: 36px;
// Misc
$list-border-radius: 5px;
$card-border-radius: 3px;
// Colors
$board-bg-color: #0079bf;
$appbar-bg-color: #0067a3;
$list-bg-color: #e2e4e6;

body {
  margin: 0;

  font-family: 'Roboto';
  font-size: 14px;
  line-height: 1.3em;
}

.ui {
  height: 100vh;
  display: grid;
  grid-template-rows: $appbar-height $navbar-height 1fr;
  background-color: $board-bg-color;
  color: #eee;
}

.circle-div {
    height: fit-content;
    width: fit-content;
    position: fixed;
    bottom: 200px;
    right: 350px;
}

.navbar {
  padding-left: $gap;
  display: flex;
  align-items: center;
  &.app {
    background-color: $appbar-bg-color;
    font-size: 1.5rem;
  }
  &.board {
    font-size: 1.1rem;
  }

  &.btn {
	background: #2ecc71;
	width: 125px;
	padding-top: 5px;
	padding-bottom: 5px;
	color: white;
	border-radius: 4px;
	border: #27ae60 1px solid;
	margin-top: 20px;
	margin-bottom: 20px;
	float: left;
	margin-left: 16px;
	font-weight: 800;
	font-size: 0.8em;
	&:hover {
		background: #2CC06B;
	}
}

}

.lists {
  display: flex;
  overflow-x: auto;
  //width: 100%; // This is needed for FF < 54
  > * {
    flex: 0 0 auto; // 'rigid' lists
    margin-left: $gap;
  }
  &::after {
    content: '';
    flex: 0 0 $gap;
  }
}

.list {
  width: $list-width;
  height: calc(100% - #{$gap} - #{$scrollbar-thickness});

  > * {
    background-color: $list-bg-color;
    color: #333;

    padding: 0 $gap;
  }

  header {
    line-height: $list-header-height;
    font-size: 16px;
    font-weight: bold;
    border-top-left-radius: $list-border-radius;
    border-top-right-radius: $list-border-radius;
  }

  footer {
    line-height: $list-footer-height;
    border-bottom-left-radius: $list-border-radius;
    border-bottom-right-radius: $list-border-radius;
    color: #888;

    &.btn {
	background: #2ecc71;
	width: 125px;
	padding-top: 5px;
	padding-bottom: 5px;
	color: white;
	border-radius: 4px;
	border: #27ae60 1px solid;
	margin-top: 20px;
	margin-bottom: 20px;
	float: left;
	margin-left: 16px;
	font-weight: 800;
	font-size: 0.8em;
	&:hover {
		background: #2CC06B;
	}
}
  }

  ul {
    list-style: none;
    margin: 0;

    max-height: calc(100% - #{$list-header-height} - #{$list-footer-height});
    overflow-y: auto;

    li {
      background-color: #fff;
      padding: $gap;
      &:not(:last-child) {
        margin-bottom: $gap;
      }

      border-radius: $card-border-radius;
      box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);

      img {
        display: block;
        width: calc(100% + 2 * #{$gap});
        margin: -$gap 0 $gap (-$gap);
        border-top-left-radius: $card-border-radius;
        border-top-right-radius: $card-border-radius;
      }
      &.nothing{
        display:none;
      }
    }
  }
}

.editCard{
  h4{
    text-align:center;
  }

}


.card {
	position: relative;
	display: -ms-flexbox;
	display: flex;
	-ms-flex-direction: column;
	flex-direction: column;
	min-width: 0;
	word-wrap: break-word;
	background-color: #fff;
	background-clip: border-box;
	border: 1px solid rgba(0, 0, 0, 0.125);
  height:200px;
	border-radius: 0.25rem;
	>.list-group {
		border-top: inherit;
		border-bottom: inherit;
		&:first-child {
			border-top-width: 0;
			border-top-left-radius: calc(0.25rem - 1px);
			border-top-right-radius: calc(0.25rem - 1px);
		}
		&:last-child {
			border-bottom-width: 0;
			border-bottom-right-radius: calc(0.25rem - 1px);
			border-bottom-left-radius: calc(0.25rem - 1px);
		}

	}

}
.card-body {
	-ms-flex: 1 1 auto;
	flex: 1 1 auto;
	min-height: 1px;
	padding: 1.25rem;
}

</style>
