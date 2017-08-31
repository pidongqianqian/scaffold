<?php
/**
 * @var $MODEL  \zgldh\Scaffold\Installer\Model\ModelDefinition
 * @var $field  \zgldh\Scaffold\Installer\Model\FieldDefinition
 */
$modelSnakeCase = $MODEL->getSnakeCase();
?>
<template>
    <div class="admin-editor-page">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>{{$MODEL->getTitle()}}
                <small v-if="form.id">编辑{{$MODEL->getTitle()}}</small>
                <small v-else>新建{{$MODEL->getTitle()}}</small>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <router-link to="/"><i class="fa fa-dashboard"></i> 总览</router-link>
                </li>
                <li>
                    <router-link to="/{{$modelSnakeCase}}/list">{{$MODEL->getTitle()}}</router-link>
                </li>
                <li class="active" v-if="form.id">编辑{{$MODEL->getTitle()}}</li>
                <li class="active" v-else>新建{{$MODEL->getTitle()}}</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="box box-default">

                <div class="box-header with-border">
                    <el-button type="default" @click="onCancel" icon="close">返回</el-button>
                    <el-button type="primary" @click="onSave" icon="check" :loading="saving||loading">
                        保存
                    </el-button>
                </div>
                <!-- /.box-header -->

                <!-- form start -->
                <div class="box-body">
                    <el-alert class="missing-errors" v-if="missingErrors.length" v-for="errorMessage in missingErrors"
                              :key="errorMessage"
                              :title="errorMessage" type="error" show-icon></el-alert>

                    <!-- form start -->
                    {!! $MODEL->generateEditorForm() !!}
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <el-button type="default" @click="onCancel" icon="close">返回</el-button>
                    <el-button type="primary" @click="onSave" icon="check" :loading="saving||loading">
                        保存
                    </el-button>
                </div>

            </div>

        </section>
        <!-- /.content -->

    </div>
</template>

<script type="javascript">
  import {mixin} from "resources/assets/js/commons/EditorHelper.js";

  export default  {
    mixins: [mixin],
    data: function () {
      return {
        form: {!! json_encode($MODEL->getDefaultValues(), JSON_PRETTY_PRINT) !!}
      };
    },
    components: {},
    computed: {
      resource: function () {
        var resourceURL = '/{{$modelSnakeCase}}';
        return (this.form.id ? resourceURL + '/' + this.form.id : resourceURL);// + '?_with=roles,permissions';
      },
@php
    $computes = $MODEL->generateComputes();
    foreach($computes as $compute):
      echo $compute.",\n";
    endforeach;
@endphp
    },
    created: function () {
      this.loading = true;
      let loads = [];
      if (this.$route.params.id) {
        this.form.id = this.$route.params.id;
        loads.push(axios.get(this.resource));
      }

      Promise.all(loads).then(results => {
        this.form = results[0].data.data;
        this.loading = false;
      }).catch(err => {
        this.loading = false;
      });
    },
    methods: {
      onSave: function (event) {
        this._onSave(event).then(result => {
          this.$router.replace('/{{$modelSnakeCase}}/' + result.data.data.id + '/edit');
          this.form = result.data.data;
          this.form.permissions = this.form.permissions.map(permission => permission.id);
        }).catch(err => {
        });
      },
      onCancel: function (event) {
        this.$router.back();
      },
      onFileChange: function (event) {
        this.form.file = event.target.files[0];
      }
    }
  };
</script>

<style lang="scss" scoped>

</style>