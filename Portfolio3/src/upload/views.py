import flask
from flask import flash
from flask import redirect
from flask import render_template
from flask import url_for
from flask.views import MethodView
import models
import re
import json


class UploadView(MethodView):

    def get(self):
        return render_template('upload.html')

    def post(self):
        name = flask.request.form.get('title')
        desc = flask.request.form.get("description")
        f = flask.request.files.get('file_path')
        print name, desc, f
        return "Successful"
