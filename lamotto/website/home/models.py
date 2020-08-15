import sys
from django.db import models
from django.utils import timezone
from datetime import date
from django.core.validators import MinValueValidator, MaxValueValidator
from PIL import Image
from io import BytesIO
from django.core.files.uploadedfile import InMemoryUploadedFile
from django.core.validators import RegexValidator

# Create your models here.
def years_number_min(last):
    return date.today().year - last


def years_number_max(maximo):
    return date.today().year + maximo

class Receiver(models.Model):
    email = models.EmailField(max_length=70, null=True, blank=True, unique=True)

    def __str__(self):
        return self.email

class Client(models.Model):
    phone_regex = RegexValidator(regex=r'^\+?1?\d{9,15}$', message="Phone number must be entered in the format: '+999999999'. Up to 12 digits allowed.")
    phone_number = models.CharField(validators=[phone_regex], max_length=12, blank=True)
    placa = models.CharField(max_length=7, blank=True)
    cedula = models.IntegerField(validators=[MaxValueValidator(999999999999), MinValueValidator(9999999)] )
    name = models.CharField(max_length=200)
    last_name = models.CharField(max_length=200)
    email = models.EmailField(max_length=70, null=True, blank=True)
    created_date = models.DateTimeField(default=timezone.now)
    model_date = models.IntegerField(default=date.today().year, validators=[MaxValueValidator(years_number_max(1)), MinValueValidator(years_number_min(20))] )

    def publish(self):
        self.created_date = timezone.now()
        self.save()

    def __str__(self):
        return self.name


