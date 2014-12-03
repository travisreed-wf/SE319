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


def allowed_image(filename):
    return '.' in filename and \
        filename.rsplit('.', 1)[1] in settingslocal.ALLOWED_IMAGE_EXTENSIONS


def get_thumbnail(extension):
    if extension == "pdf":
        return models.Thumbnail.query.filter_by(id=1).first()
    elif extesnion == "txt":
        return models.Thumbnail.query.filter_by(id=2).first()
    else:
        return models.Thumbnail.query.filter_by(id=3).first()


class UploadView(MethodView):

    def get(self):
        return render_template('upload.html')

    def post(self):
        name = flask.request.form.get('title')
        desc = flask.request.form.get("description")
        f = flask.request.files.get('file_path')
        thumbnail = flask.request.files.get('thumbnail')
        if f and allowed_file(f.filename):
            if thumbnail and allowed_image(thumbnail.filename):
                db_thumbnail = models.Thumbnail(thumbnail.filename)
                models.db.session.add(db_thumbnail)
                models.db.session.commit()
            else:
                db_thumbnail = get_thumbnail(f.filename.split('.')[-1])
            item = models.Item(name, f.filename, db_thumbnail.id)
            item.description = desc
            models.db.session.add(item)
            models.db.session.commit()
            f.save(os.path.join("src/static/uploads", item.get_filename()))
            thumbnail.save(os.path.join("src/static/uploads/thumbnails",
                           db_thumbnail.get_filename()))

            return redirect(url_for('uploaded_file',
                                    filename=item.get_filename()))
        return "Failed"


class UploadedFileView(MethodView):

    def get(self, filename):
        return flask.send_file("static/uploads/" + filename)