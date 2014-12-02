import flask
from flask import Flask
from flask import flash
from flask import redirect
from flask import render_template
from flask import url_for
from flask.views import MethodView
from werkzeug import secure_filename

import os
import json
import re

import models
import settingslocal


def allowed_file(filename):
        return '.' in filename and \
            filename.rsplit('.', 1)[1] in settingslocal.ALLOWED_EXTENSIONS


class UploadView(MethodView):

    def get(self):
        return render_template('upload.html')

    def post(self):
        name = flask.request.form.get('title')
        desc = flask.request.form.get("description")
        f = flask.request.files.get('file_path')
        if f and allowed_file(f.filename):
            item = models.Item(name)
            item.description = desc
            models.db.session.add(item)
            models.db.session.commit()
            f.save(os.path.join("src/static/uploads", str(item.id)))
            return redirect(url_for('uploaded_file',
                                    item_id=item.id))
        return "Failed"


class UploadedFileView(MethodView):

    def get(self, item_id):
        return flask.send_file("static/uploads/" + str(item_id))