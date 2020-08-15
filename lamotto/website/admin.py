from django.contrib import admin
from .home.models import Client, Receiver
# Register your models here.

admin.site.register(Client)
admin.site.register(Receiver)
